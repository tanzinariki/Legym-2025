<?php
require_once 'inc/header.php';
require_once 'inc/preload.php';
?>
<section class="sectionStyle">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-xs-12 login">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 text-center loginHead">
                            <h2><a href="index.html"><span>Le Gym</span></a></h2>
                            <h4><span>Welcome</span></h4>
                            <p class="subTitle">Please enter your details to sign in</p>
                        </div>
                        <div class="loginForm">
                            <form id="loginForm" method="post" action="" class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <label for="email">Email Address</label>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 input-group input-margin-bottom"  data-target-input="nearest">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input class="form-control input-style-2 input-group-left-img" id="email" type="text" name="email" value="" placeholder="Enter your email" readonly onfocus="this.removeAttribute('readonly');" />
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <label for="password">Password</label>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 input-group input-margin-bottom"  data-target-input="nearest">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="far fa-question-circle"></i>
                                        </div>
                                    </div>
                                    <input class="form-control input-style-2 input-group-left-img" id="password" type="password" name="password" value="" placeholder="Enter your password" readonly onfocus="this.removeAttribute('readonly');" />
                                </div>
                                <div class="col-xl-12 col-lg-6 col-md-6 col-xs-6">
                                    <div class="form-group form-check">
                                        <!-- <input type="checkbox" class="form-check-input" id="remember-me" name="rememberme">
                                        <label class="form-check-label" for="remember-me">Remember me</label> -->
                                        <a href="forgot_password.php" for="con_name" style="float: right;">Forgot Password?</a>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 submitBtnDiv">
                                    <button class="form-control ind_btn_2" type="submit" style="line-height: 40px;">
                                        <span>
                                            Sign In
                                            <i class="fal fa-long-arrow-right"></i>
                                        </span>
                                    </button>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12" style="margin: 15px 0; text-align: center;">
                                    <p>Don't have an acoount? <a href="signup.php" target="">Signup for free</a></p>
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
        let password = document.getElementById("password");

        if (email) {
            email.value = "";
            email.setAttribute("autocomplete", "off");
        }

        if (password) {
            password.value = "";
            password.setAttribute("autocomplete", "new-password");
        }
    }, 100); // Clears autofilled values after 0.5s
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("loginForm").addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        fetch("http://localhost/legym/user/production/login_process.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === "success") {
                Swal.fire({
                    icon: "success",
                    title: "Success!",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect;
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: data.message
                });
            }
        })
        .catch(error => console.error("Fetch Error:", error));
    });
});
</script>
