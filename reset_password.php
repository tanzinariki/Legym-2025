<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'inc/header.php';
require_once 'inc/preload.php';
require_once 'user/production/db_connect.php';

$showForm = true;
$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $temp_password = trim($_POST['temp_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if (empty($temp_password) || empty($new_password) || empty($confirm_password)) {
        $errorMessage = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $errorMessage = "Passwords do not match.";
    } else {
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            $errorMessage = "Database connection failed.";
        } else {
            // Fetch all users and verify temporary password using password_verify
            $stmt = $conn->prepare("SELECT id, password FROM user");
            $stmt->execute();
            $stmt->bind_result($user_id, $stored_hash);

            $match_found = false;
            while ($stmt->fetch()) {
                if (password_verify($temp_password, $stored_hash)) {
                    $match_found = true;
                    break;
                }
            }
            $stmt->close();

            if ($match_found) {
                $hashed_new = password_hash($new_password, PASSWORD_BCRYPT);
                $updateStmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
                $updateStmt->bind_param("si", $hashed_new, $user_id);

                if ($updateStmt->execute()) {
                    $successMessage = "Your password has been reset successfully.";
                    $showForm = false;
                } else {
                    $errorMessage = "Failed to reset password.";
                }
                $updateStmt->close();
            } else {
                $errorMessage = "Temporary password is incorrect.";
            }

            $conn->close();
        }
    }
}
?>

<section class="sectionStyle">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-xs-12 login">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 text-center loginHead">
                            <h2><a href="index.php"><span>Le Gym</span></a></h2>
                            <h4><span><?= $showForm ? 'Reset Your Password' : 'Password Reset'; ?></span></h4>
                            <p class="subTitle">
                                <?= $showForm ? 'Please provide your temporary password, then set your new password' : $successMessage; ?>
                            </p>
                        </div>
                        <div class="loginForm">
                            <?php if ($showForm): ?>
                                <form method="POST" class="row" id="resetPasswordForm">
                                    <?php if (!empty($errorMessage)): ?>
                                        <div class="col-xl-12">
                                            <div class="alert alert-danger text-center"><?= $errorMessage; ?></div>
                                        </div>
                                    <?php endif; ?>

                                    <div class="col-xl-12">
                                        <label for="temp_password">Temporary Password</label>
                                    </div>
                                    <div class="col-xl-12 input-group input-margin-bottom">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fas fa-key"></i></div>
                                        </div>
                                        <input type="password" name="temp_password" id="temp_password" class="form-control input-style-2 input-group-left-img" placeholder="Enter your temporary password" required>
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="new_password">New Password</label>
                                    </div>
                                    <div class="col-xl-12 input-group input-margin-bottom">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                        </div>
                                        <input type="password" name="new_password" id="new_password" class="form-control input-style-2 input-group-left-img" placeholder="Enter new password" required>
                                    </div>

                                    <div class="col-xl-12">
                                        <label for="confirm_password">Confirm New Password</label>
                                    </div>
                                    <div class="col-xl-12 input-group input-margin-bottom">
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fas fa-lock"></i></div>
                                        </div>
                                        <input type="password" name="confirm_password" id="confirm_password" class="form-control input-style-2 input-group-left-img" placeholder="Confirm new password" required>
                                    </div>

                                    <div class="col-xl-12 submitBtnDiv">
                                        <button type="submit" class="form-control ind_btn_2" style="line-height: 40px;">
                                            <span>Set New Password</span>
                                        </button>
                                    </div>
                                    <div class="col-xl-12" style="margin: 15px 0; text-align: center;">
                                        <p><a href="login.php"><i class="fal fa-long-arrow-left" style="margin-right: 10px;"></i>Back to Login</a></p>
                                        <p>© 2025 Le Gym. All rights reserved.</p>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form class="row text-center">
                                    <div class="col-xl-12">
                                        <div class="alert alert-success"><?= $successMessage; ?></div>
                                    </div>
                                    <div class="col-xl-12 submitBtnDiv">
                                        <a href="login.php" class="form-control ind_btn_2" style="line-height: 40px;">Login</a>
                                    </div>
                                    <div class="col-xl-12" style="margin: 15px 0;">
                                        <p>© 2025 Le Gym. All rights reserved.</p>
                                    </div>
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'inc/footer.php'; ?>
