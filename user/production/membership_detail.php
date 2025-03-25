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
$qr = "SELECT user.*, mp.plan_name, mp.plan_cost, mp.plan_discounts, mp.plan_benefit  
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
            <div class="page-title">
                <div class="title_left">
                    <h3>Membership Information</h3>
                    <h5>View and manage your membership information.</h5>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Current Status</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="in-person-fitness-form" data-parsley-validate class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="x_content membership-plan-card">
                                            <button class="btn btn-<?php echo $status == 'Active' ? 'success' : 'danger'; ?> btn-sm disable-btn"><?php echo $status == 'Active' ? 'A' : 'Ina'; ?>ctive</button>
                                            <p><?php echo $plan_name; ?></p>
                                            <p><?php echo $plan_cost; ?>$ /month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_content membership-date-card">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding: 0;">
                                                <p class="heading">Start Date</p>
                                                <p><?php echo date('F d, Y', strtotime($membership_start_date)) ?></p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding: 0;">
                                                <p class="heading">End Date</p>
                                                <p><?php echo date('F d, Y', strtotime($membership_end_date)) ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <a href="payment.php" class="btn btn-success" style="float: left;">Renew/Change Memebership</a>
                                    </div>
                                </div>
                            </form>
                            <div class="ln_solid"></div>
                            <div class="form-group">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="x_content membership-benefit-card">
                                        <h4>Membership Benefits</h4>
                                        <ul>
                                            <?php
                                            $plan_benefit = explode('|', $plan_benefit);
                                            foreach ($plan_benefit as $plan_benefit) {
                                                echo '<li><img src="images/membership-info/circle-tick.png" />'.$plan_benefit.'</li>';
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 15px; margin-top: 15px;">
                                    Current Discount
                                </label>
                                <?php
                                if (empty($plan_discounts)) {
                                    echo 'Curently we have no discount offer available!';
                                } else {
                                    $plan_discounts = explode(', ', $plan_discounts);
                                    foreach ($plan_discounts as $plan_discounts) {
                                        $plan_discounts = explode(' - ', $plan_discounts);
                                        echo '<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
                                        echo '<div class="x_content reward-card">';
                                        echo '<img style="margin-right: 5px;" src="images/membership-info/tag.png" />';
                                        echo '<span>'.$plan_discounts[0].'</span>';
                                        echo '<p>'.$plan_discounts[1].'</p>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <?php require_once 'inc/copyright.php'; ?>
      </div>
    </div>
<?php require_once 'inc/footer.php'; ?>