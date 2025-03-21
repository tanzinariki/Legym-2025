<?php
require_once 'inc/header.php';
require_once 'inc/preload.php';
?>
<section class="sectionStyle">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-xs-12 forgotPassword">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 text-center forgotPasswordHead">
                            <h2><a href="index.html"><span>Le Gym</span></a></h2>
                            <p class="subTitle">Reset your password</p>
                        </div>
                        <div class="forgotPasswordForm">
                            <form id="forgotPasswordForm" method="post" action="#" class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <label for="email">Email Address</label>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 input-group input-margin-bottom"  data-target-input="nearest">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input class="form-control input-style-2 input-group-left-img" id="email" type="text" name="" value="" placeholder="Enter your email" />
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 submitBtnDiv">
                                    <button class="form-control ind_btn_2" type="button" style="line-height: 40px;">
                                        <span>
                                            <i class="fas fa-key"></i>
                                            Reset Password
                                        </span>
                                    </button>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12" style="margin: 15px 0; text-align: center;">
                                    <p><a href="login.php" target=""><i class="fal fa-long-arrow-left" style="margin-right: 10px;"></i>Back to Login</a></p>
                                    <p>© 2025 Le Gym. All rights reserved.</p>
                                </div>
                            </form>                                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
require_once 'inc/footer.php';
?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    setTimeout(() => {
        let email = document.getElementById("email");

        if (email) {
            email.value = "";
            email.setAttribute("autocomplete", "off");
        }
    }, 100); // Clears autofilled values after 0.5s
});
</script>