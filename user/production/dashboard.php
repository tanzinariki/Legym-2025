<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
} else {
    header("Location: http://localhost/legym/login.php");
    exit;
}

require_once "db_connect.php"; // Include your database connection file

// Query to get the user's Member Plan
$qr = "SELECT user.*, mp.plan_name, mp.plan_cost, mp.plan_discounts  
        FROM user 
        LEFT JOIN membership_plan AS mp 
        ON user.membership_plan_id = mp.id 
        WHERE user.id = ?";

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();

while ($user = $res->fetch_assoc()) {
    extract($user);
}





// Query to get the user's upcoming online, in-person training session.
$qr = 'SELECT user_training.*, training.training_date
        FROM user_training
        JOIN training 
        ON user_training.training_id = training.id
        WHERE user_training.user_id = 1 
        AND user_training.status = "Booked"
        AND training.training_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)';

// Query to get the user's online, in-person training session count upcoming 30 days.
$qr = 'SELECT COUNT(user_training.id) AS count
        FROM user_training
        JOIN training 
        ON user_training.training_id = training.id
        WHERE user_training.user_id = ? 
        AND user_training.status = "Booked"
        AND training.training_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$training_total = $res->fetch_assoc();

// Query to get the user's personal training session count upcoming 30 days.
$qr = 'SELECT COUNT(user_personal_training.id) AS count
        FROM user_personal_training
        JOIN trainer_availability 
        ON user_personal_training.trainer_availability_id = trainer_availability.id
        WHERE user_personal_training.user_id = ? 
        AND user_personal_training.cancel_at IS NULL
        AND trainer_availability.date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$personal_training_total = $res->fetch_assoc();

// Query to get the user's online, in-person training session count previous 30 days.
$qr = 'SELECT COUNT(user_training.id) AS count
        FROM user_training
        JOIN training 
        ON user_training.training_id = training.id
        WHERE user_training.user_id = ? 
        AND user_training.status = "Booked"
        AND training.training_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$prev_training_total = $res->fetch_assoc();

// Query to get the user's personal training session count previous 30 days.
$qr = 'SELECT COUNT(user_personal_training.id) AS count
        FROM user_personal_training
        JOIN trainer_availability 
        ON user_personal_training.trainer_availability_id = trainer_availability.id
        WHERE user_personal_training.user_id = ? 
        AND user_personal_training.cancel_at IS NULL
        AND trainer_availability.date BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND DATE_SUB(CURDATE(), INTERVAL 1 DAY)';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$prev_personal_training_total = $res->fetch_assoc();




// Query to get the user's accepted ongoing challenges.
$qr = 'SELECT user_challenges.*, challenges.*
        FROM user_challenges
        JOIN challenges 
        ON user_challenges.challenge_id = challenges.id
        WHERE user_challenges.user_id = ?
        AND challenges.end_date > NOW()
        ORDER BY challenges.end_date';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res_accepted_ongoing_challenge = $qr->get_result();

// Query to get the user's accepted challenges count.
$qr = 'SELECT COUNT(user_challenges.id) AS count
        FROM user_challenges
        JOIN challenges 
        ON user_challenges.challenge_id = challenges.id
        WHERE user_challenges.user_id = ?';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$accepted_challenge_total = $res->fetch_assoc();

// Query to get the user's completed challenges count.
$qr = 'SELECT COUNT(user_challenges.id) AS count
        FROM user_challenges
        JOIN challenges 
        ON user_challenges.challenge_id = challenges.id
        WHERE user_challenges.user_id = ? 
        AND user_challenges.progress = 100';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$completed_challenge_total = $res->fetch_assoc();

// Query to get the user's failed challenges count.
$qr = 'SELECT COUNT(user_challenges.id) AS count
        FROM user_challenges
        JOIN challenges 
        ON user_challenges.challenge_id = challenges.id
        WHERE user_challenges.user_id = ? 
        AND user_challenges.progress < 100
        AND challenges.end_date < NOW()';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res = $qr->get_result();
$failed_challenge_total = $res->fetch_assoc();






// Query to get the user's rented locker for today.
$qr = 'SELECT locker.locker_name, user_locker.rent_duration 
        FROM user_locker 
        JOIN locker 
        ON user_locker.locker_id = locker.id 
        WHERE user_locker.user_id = ? 
        AND DATE(user_locker.rent_date) = CURDATE()';

$qr = $conn->prepare($qr);
$qr->bind_param("s", $_SESSION['user_id']);
$qr->execute();
$res_rented_locker = $qr->get_result();







// Query to get the user's upcoming online, in-person training session.
$qr = "SELECT 
            ut.id,
            ut.booking_at AS booking_time,
            ut.date AS training_date,
            ut.timeslot AS training_time,
            ut.status,
            trainer.trainer_name,
            NULL AS class_name,
            NULL AS class_type,
            NULL AS online_training_link,
            NULL AS total_seats
            FROM 
                (SELECT
                    user_personal_training.id, user_personal_training.booking_at, user_personal_training.status,
                    trainer_availability.trainer_id, trainer_availability.date, trainer_availability.timeslot
                    FROM user_personal_training
                    JOIN trainer_availability 
                    ON user_personal_training.trainer_availability_id = trainer_availability.id
                    WHERE user_personal_training.user_id = ? 
                    AND user_personal_training.status  = 'Booked'
                    AND trainer_availability.date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)) AS ut
            JOIN trainer
            ON ut.trainer_id = trainer.id

        UNION ALL

        SELECT	
            upt.id, 
            upt.booking_time, 
            upt.training_date, 
            upt.training_time, 
            upt.status, 
		    trainer.trainer_name, 
            legym_class.class_name, 
            legym_class.class_type, 
            upt.online_training_link, 
            upt.total_seats
        FROM
		    (SELECT 
         	    user_training.id, user_training.booking_time, user_training.status, 
         	    training.class_id, training.training_date, training.training_time, training.online_training_link, training.trainer_id, training.total_seats
                FROM user_training
                JOIN training 
                ON user_training.training_id = training.id
                WHERE user_training.user_id = ? 
                AND user_training.status = 'Booked'
                AND training.training_date BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)) 
            AS upt
        JOIN trainer
        ON upt.trainer_id = trainer.id
        JOIN legym_class
        ON upt.class_id = legym_class.id
        ORDER BY training_date, training_time";

$qr = $conn->prepare($qr);
$qr->bind_param("ii", $_SESSION['user_id'], $_SESSION['user_id']);
$qr->execute();
$res_upcoming_session = $qr->get_result();

require_once 'inc/header.php';
?>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <?php require_once 'inc/top_left_nav.php'; ?>
            <div class="clearfix"></div>
            <?php 
            require_once 'inc/menu_profile.php';
            require_once 'inc/sidebar.php';
            ?>
          </div>
        </div>
        <?php require_once 'inc/top_nav.php'; ?>

        <!-- page content -->
        <div class="right_col" role="main">
            <div class="row" style="padding: 10px 0 0;">
                <div class="animated flipInY col-lg-3 col-md-5 col-sm-6 col-xs-12">
                    <div class="container-fluid tile-stats equal-height" style="padding: 0; height: 180px;">
                        <?php
                        if (empty($plan_name)) {
                        ?>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px;">
                            <div class="count green-font" style="font-size: 20px; margin: 10px;">
                                Inactive
                            </div>
                            <p class="green-font" style="font-size: 14px; position: relative; bottom: 3px;">No Plan Selected</p>
                            <a href="payment.php" class="btn btn-success" style="margin: 12px 9px;">Buy Plan</a>
                        </div>

                        <?php
                        } 
                        else {
                        ?>
                        
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px;">
                            <div class="">
                                <span class="green-font" style="font-size: 20px; margin: 16px 10px; display: inline-block;"><?php echo $plan_name; ?></span>
                                <a href="membership_detail.php" class="btn btn-success" style="margin-top: 15px; float: right;">Detail</a>
                            </div>

                            <h3 style="display: inline-block; position: relative;">
                                $<?php echo $plan_cost; ?>
                                <span class="green-font">/</span>
                            </h3>
                            <span class="green-font" style="font-size: 14px; position: relative; bottom: 3px;">month</span>
                            <p>Start Date : <?php echo date('M d, Y', strtotime($membership_start_date)) ?></p>
                            <p style="margin-top: 0;">End Date : <?php echo date('M d, Y', strtotime($membership_end_date)) ?></p>
                        </div>

                        <?php
                        }
                        ?>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-5 col-sm-6 col-xs-12">
                    <div class="container-fluid tile-stats equal-height" style="padding: 0; height: 180px;">
                        <h3 style="margin-top: 15px; padding-left: 5px;">Sessions</h3>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding: 10px 5px;">
                            <div class="count red-font" style="margin-bottom: 10px;">
                            <?php echo $training_total['count'] + $personal_training_total['count'] ?>
                            </div>
                            <p class="small-card red-font" style="font-weight: bold;">Upcoming</p>
                            <p class="small-card red-font">Till Next 30 Days</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding: 10px 5px;">
                            <div class="count green-font" style="margin-bottom: 10px;">
                            <?php echo $prev_training_total['count'] + $prev_personal_training_total['count'] ?>
                            </div>
                            <p class="small-card green-font" style="font-weight: bold;">Completed</p>
                            <p class="small-card green-font">In Last 30 Days</p>
                        </div>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-5 col-sm-6 col-xs-12">
                    <div class="container-fluid tile-stats equal-height" style="padding: 0; height: 180px;">
                        <h3 style="margin-top: 15px; padding-left: 5px;">Challenges</h3>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding: 10px 5px;">
                            <div class="count" style="margin-bottom: 10px;">
                                <span class="green-font"><?php echo $completed_challenge_total['count'] ?></span>
                                <!-- <span>/</span><span class="red-font"><?php // echo $accepted_challenge_total['count'] ?></span> -->
                            </div>
                            <p class="small-card green-font" style="font-weight: bold;">Completed Succesfully</p>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="padding: 10px 5px;">
                            <div class="count" style="margin-bottom: 10px;">
                                <span class="red-font"><?php echo $failed_challenge_total['count'] ?></span>
                            </div>
                            <p class="small-card red-font" style="font-weight: bold;">Failed to <br />Complete</p>
                        </div>
                    </div>
                </div>
                <div class="animated flipInY col-lg-3 col-md-5 col-sm-6 col-xs-12">
                    <div class="container-fluid tile-stats equal-height" style="padding: 0; height: 180px;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px;">
                            <h3 style="margin-top: 15px;">Rented Locker</h3>
                            <?php
                            if ($res_rented_locker->num_rows > 0) {
                                while ($rented_locker = $res_rented_locker->fetch_assoc()) {
                            ?>
                            <div class="" style="display: inline-block; width: 60px; margin: 10px;">
                                <h1 class="count" style="margin-left: 0;"><?php echo $rented_locker['locker_name'] ?></h1>
                                <?php 
                                $rent_duration = explode(" - ", $rented_locker['rent_duration']);
                                foreach ($rent_duration as $rent_duration) {
                                    echo  '<span>'.$rent_duration.'</span> ';
                                }
                                ?>
                            </div>
                            <?php
                                }
                            }
                            else {
                                echo '<p class="font-style-1">No Locker is Rented.</p>';
                            }
                            ?>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px;">
                            <!-- <a href="membership_detail.php" class="btn btn-success" style="margin: 10px;">Change Goal</a> -->
                        </div>
                    </div>
                </div>
                <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="container-fluid tile-stats equal-height" style="padding: 0; height: auto;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px 10px;">
                            <h3 style="margin-top: 15px;">Fitness Goals</h3>
                            <p class="font-style-1">
                            <?php
                            if (empty($fitness_goal)) {
                                echo 'No Fitness Goals Selected.';
                            } 
                            else {
                            ?> 
                                <ul class="font-style-1" style="font-size: 13px !important; padding-left: 25px; margin-top: 10px; font-weight: bold; letter-spacing: 0.5px; list-style-type: disclosure-closed;">
                                    <?php
                                    $fitness_goal = explode(", ", $fitness_goal);
                                    foreach ($fitness_goal as $fitness_goal) {
                                        echo "<li>$fitness_goal</li>";
                                    }
                                    ?>
                                </ul>
                            <?php
                            }
                            ?>
                            </p>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0 5px;">
                            <!-- <a href="membership_detail.php" class="btn btn-success" style="margin: 10px;">Change Goal</a> -->
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Your Upcoming Sessions</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php
                            if ($res_upcoming_session->num_rows > 0) {
                                while ($upcoming_session = $res_upcoming_session->fetch_assoc()) {
                                    $train_month = date('F', strtotime($upcoming_session['training_date'])); 
                                    $train_day = date('d', strtotime($upcoming_session['training_date']));
                            ?>
                            <article class="media event">
                                <a class="pull-left date">
                                    <p class="month">Start Date</p>
                                    <p class="month"><?php echo $train_month ?></p>
                                    <p class="day"><?php echo $train_day ?></p>
                                </a>
                                <div class="media-body">
                                    <?php
                                    if ($upcoming_session['class_name'] != NULL) {
                                        echo '<p>'.$upcoming_session['class_name'].'</p>';
                                    } else {
                                        echo '<p>Personal Training Session</p>';
                                    }
                                    ?>
                                    <span class="font-style-3">Trainer <i class="fa fa-arrow-right"></i></span>
                                    <span class="font-style-3"><?php echo $upcoming_session['trainer_name'] ?></span>
                                    <br />
                                    <span class="font-style-3">Class Type <i class="fa fa-arrow-right"></i></span>
                                    <?php
                                    if ($upcoming_session['class_type'] != NULL) {
                                        echo '<span class="font-style-3">'.$upcoming_session['class_type'].'</span>';
                                    } else {
                                        echo 'Personal';
                                    }
                                    
                                    echo '<br /><span class="font-style-3">Start On - </i></span>';
                                    if (strpos($upcoming_session['training_time'], '-') !== false) {
                                        $train_time = explode(' - ', $upcoming_session['training_time']);
                                        $start_time = $train_time[0];
                                    } else {
                                        $start_time = date('h:i a', strtotime($upcoming_session['training_time']));
                                    }
                                    echo '<span class="font-style-3">'.$start_time.'</span><br />';

                                    if ($upcoming_session['online_training_link'] != NULL) {
                                        echo '<span class="font-style-3">Join Link : </i></span><br />';
                                        echo '<span class="font-style-3">'.$upcoming_session['online_training_link'].'</span><br />';
                                    }

                                    if ($upcoming_session['total_seats'] != NULL) {
                                        echo '<span class="font-style-3">Total Seats : </i></span>';
                                        echo '<span class="font-style-3">'.$upcoming_session['total_seats'].'</span>';
                                    }
                                    ?>
                                </div>
                            </article>
                            <?php
                                }
                            } else {
                                echo 'You are currently not engaged in any fitness challenge!';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Ongoing Challenges!</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <?php
                            if ($res_accepted_ongoing_challenge->num_rows > 0) {
                                while ($accepted_ongoing_challenge = $res_accepted_ongoing_challenge->fetch_assoc()) {
                                    $end_month = date('F', strtotime($accepted_ongoing_challenge['end_date'])); 
                                    $end_day = date('d', strtotime($accepted_ongoing_challenge['end_date']));
                                    $joined_date = date('Y-m-d', strtotime($accepted_ongoing_challenge['joined_time']));
                            ?>
                            <article class="media event">
                                <a class="pull-left date">
                                    <p class="month">End On</p>
                                    <p class="month"><?php echo $end_month ?></p>
                                    <p class="day"><?php echo $end_day ?></p>
                                </a>
                                <div class="media-body">
                                    <p><?php echo $accepted_ongoing_challenge['name'] ?></p>
                                    <span class="font-style-3">Description <i class="fa fa-arrow-right"></i></span>
                                    <span class="font-style-3"><?php echo $accepted_ongoing_challenge['description'] ?></span>
                                    <p class="font-style-1" style="font-size: 12px !important; letter-spacing: 0;">Start Date - <?php echo $accepted_ongoing_challenge['start_date'] ?></p>
                                    <p class="font-style-1" style="font-size: 12px !important; letter-spacing: 0;">Joined Date - <?php echo $joined_date ?></p>
                                    <?php
                                    if ($accepted_ongoing_challenge['completion_time'] != NULL) {
                                        echo '<p class="font-style-1" style="font-size: 12px !important; letter-spacing: 0;">Completed On - '.$accepted_ongoing_challenge['completion_time'].'</p>';
                                    }
                                    ?>
                                    <span class="font-style-3">Progress <i class="fa fa-arrow-right"></i></span>
                                    <span class="font-style-3"><?php echo $accepted_ongoing_challenge['progress'] ?></span>
                                    <div class="progress progress_sm">
                                        <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php echo $accepted_ongoing_challenge['progress'] ?>"></div>
                                    </div>
                                </div>
                            </article>
                            <?php
                                }
                            } else {
                                echo 'You are currently not engaged in any fitness challenge!';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <?php require_once 'inc/copyright.php'; ?>
      </div>
    </div>
<?php
require_once 'inc/footer.php';
?>