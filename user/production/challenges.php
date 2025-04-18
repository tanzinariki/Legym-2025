<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
	header("Location: http://localhost/legym/login.php");
	exit;
}

if ($_SESSION['status'] != 'Active') {
	header("Location: http://localhost/legym/user/production/dashboard.php");
	exit;
}

$fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];

require_once 'inc/header.php';
require_once 'db_connect.php';

// Get only active challenges (end_date >= today)
$challenges = [];
$currentDate = date('Y-m-d');
$challengeStmt = $conn->prepare("SELECT id, name, end_date FROM challenges WHERE end_date >= ?");
$challengeStmt->bind_param('s', $currentDate);
$challengeStmt->execute();
$challenges = $challengeStmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Initialize variables
$selectedChallenge = null;
$joinedUsers = [];
$error = $success = '';

if (isset($_GET['challenge_id'])) {
    $selectedChallengeId = (int)$_GET['challenge_id'];
    
    // Get challenge details with active check
    $stmt = $conn->prepare("SELECT * FROM challenges WHERE id = ? AND end_date >= ?");
    $stmt->bind_param('is', $selectedChallengeId, $currentDate);
    $stmt->execute();
    $selectedChallenge = $stmt->get_result()->fetch_assoc();
    
    if ($selectedChallenge) {
        // Get joined members
        $userStmt = $conn->prepare("
            SELECT u.first_name, u.last_name 
            FROM user_challenges uc 
            JOIN user u ON uc.user_id = u.id 
            WHERE uc.challenge_id = ?
        ");
        $userStmt->bind_param('i', $selectedChallengeId);
        $userStmt->execute();
        $joinedUsers = $userStmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// Handle messages
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
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
                    <h3>Join Fitness Challenge</h3>
                    <h5>Let's take the challenge.</h5>
                </div>
            </div>
            <div class="clearfix"></div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Available Fitness Challenges</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="challenge-form"  class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label class="control-label col-md-12" for="challenge-name">
                                        Challenge <span class="required">*</span>
                                    </label>
                                    <div class="col-md-12">
                                        <select 
                                            class="form-control select2-single" 
                                            id="challenge-name" 
                                            name="challenge_id" 
                                            required
                                        >
                                            <option value="">Select Challenge</option>
                                            <?php foreach ($challenges as $challenge): ?>
                                                <option 
                                                    value="<?= htmlspecialchars($challenge['id']) ?>" 
                                                    <?= isset($selectedChallenge) && $selectedChallenge['id'] == $challenge['id'] ? 'selected' : '' ?>
                                                    data-end-date="<?= htmlspecialchars($challenge['end_date']) ?>"
                                                >
                                                    <?= htmlspecialchars($challenge['name']) ?>
                                                    (Until <?= date('M j', strtotime($challenge['end_date'])) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <?php if ($selectedChallenge): ?>
                                    <div class="form-group">
                                        <label class="control-label col-md-12">
                                            Assigned Trainer
                                        </label>
                                        <div class="col-md-12">
                                            <h2 
                                                style="margin-top: 10px;" 
                                                readonly 
                                                style="height: auto;"
                                            >
                                            <?php
                                            $sql = "SELECT * FROM trainer WHERE id = ?";
                                            $qr = $conn->prepare($sql);
                                            $qr->bind_param("i", $selectedChallenge['trainer_id']);
                                            $qr->execute();
                                            $trainer = $qr->get_result()->fetch_assoc();
                                            ?>
                                            <?= htmlspecialchars($trainer['trainer_name']) ?></h2>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-12">
                                            Challenge Description
                                        </label>
                                        <div class="col-md-12">
                                            <textarea 
                                                class="form-control readonly-text-area-style-1" 
                                                readonly 
                                                style="height: 100px;"
                                            ><?= htmlspecialchars($selectedChallenge['description']) ?></textarea>
                                        </div>
                                    </div>

                                    <!-- Restored Original Rewards Section -->
                                    <div class="form-group">
                                        <label class="control-label col-md-12">
                                            Rewards
                                        </label>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <?php $rewards = explode('|', htmlspecialchars($selectedChallenge['reward'])) ?>
                                                <?php foreach ($rewards as $reward): ?>
                                                    <?php $reward = explode('##', $reward) ?>
                                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                        <div class="x_content reward-card">
                                                            <img 
                                                            <?php 
                                                                if ($reward[0] == 'reward') {
                                                                    echo 'src="images/fitness-challenge/bonus-reward.png"';
                                                                } else if ($reward[0] == 'top') {
                                                                    echo 'src="images/fitness-challenge/top-3.png"';
                                                                } else {
                                                                    echo 'src="images/fitness-challenge/gold-badge.png"';
                                                                }
                                                            ?>
                                                             />
                                                            <?php $reward_des = explode('#', $reward[1]) ?>
                                                            <p><?= htmlspecialchars($reward_des[0]) ?></p>
                                                            <span><?= htmlspecialchars($reward_des[1]) ?></span>
                                                        </div>
                                                    </div>
                                                <?php endforeach; ?>
                                                <!-- <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="x_content reward-card">
                                                        <img src="images/fitness-challenge/gold-badge.png" />
                                                        <p>Gold Badge</p>
                                                        <span>Complete 100%</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="x_content reward-card">
                                                        <img src="images/fitness-challenge/top-3.png" />
                                                        <p>Premium Pass</p>
                                                        <span>Top 3 Finisher</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                                    <div class="x_content reward-card">
                                                        <img src="images/fitness-challenge/bonus-reward.png" />
                                                        <p>Bonus Point</p>
                                                        <span>Daily Competition</span>
                                                    </div>
                                                </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-12">
                                            Members Joined
                                        </label>
                                        <div class="col-md-12">
                                            <ol style="padding: 10px 15px;">
                                                <?php if (!empty($joinedUsers)): ?>
                                                    <?php foreach ($joinedUsers as $user): ?>
                                                        <li><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></li>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <li>No participants yet. Be the first!</li>
                                                <?php endif; ?>
                                            </ol>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="ln_solid"></div>
                                <?php if ($selectedChallenge): ?>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <button type="button" class="btn btn-success join-btn" style="float: right;">
                                                Join Challenge
                                            </button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </form>
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

<script>
$(document).ready(function() {
    $('.select2-single').select2();
    
    $('#challenge-name').on('change', function() {
        if ($(this).val()) {
            window.location.href = 'challenges.php?challenge_id=' + $(this).val();
        }
    });
    
    // Disable expired challenges
    $('option[data-end-date]').each(function() {
        const endDate = new Date($(this).data('end-date'));
        if (endDate < new Date()) {
            $(this).prop('disabled', true).text(
                $(this).text() + ' (Expired)'
            );
        }
    });

    // Join
	$(document).on('click', '.join-btn', function() {
		var btn = $(this);
		var challenge_id = $('#challenge-name').val();
        console.log(challenge_id);
		if (typeof challenge_id !== 'undefined' && challenge_id !== null && challenge_id !== '') {
			Swal.fire({
				title: "Are you sure?",
				text: "After joining the challenge you cannot leave!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Join!"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: 'challenges_process.php',
						type: 'POST',
						dataType: 'json',
						data: { action: 'join', challenge_id: challenge_id },
						success: function(response) {
							console.log(response);
							if(response.success) {
								Swal.fire({
									title: "Joined!",
									text: "You have joined the challenge successfully.",
									icon: "success"
								}).then(() => {
									//window.location.href = "challenges.php";
								});
							} else {
                                Swal.fire({
									title: "Oops!",
									text: "You\'ve already joined this challenge!",
									icon: "info"
								}).then(() => {
									// window.location.href = "challenges.php";
								});
                            }
						}
					});
				}
			});
		} else {
			Swal.fire({
				title: "Error!",
				text: response.message,
				icon: "error",
				confirmButtonText: "OK"
			});
		}
	});
});
</script>