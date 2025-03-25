<?php
require_once 'inc/header.php';
require_once 'inc/preload.php';
?>
<section class="sectionStyle">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-xs-12 forgotPassword">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 text-center signupHead">
                            <h2><a href="index.php"><span>Le Gym</span></a></h2>
                            <p class="subTitle">Join our fitness community and start your wellness journey.</p>
                        </div>
                        <div class="signupForm">
                            <form id="signupForm" method="post" action="http://localhost/legym/user/production/signup_process.php" class="row">
                                <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 input-margin-bottom">
                                    <label for="first-name">First Name</label>
                                    <input class="form-control input-style-2" id="first-name" type="text" name="first_name" value="" placeholder="Enter your first name" />
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12 input-margin-bottom">
                                    <label for="last-name">Last Name</label>
                                    <input class="form-control input-style-2" id="last-name" type="text" name="last_name" value="" placeholder="Enter your last name" />
                                </div>
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
                                <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                                    <label for="password">Password</label>
                                    <div class="input-group input-margin-bottom"  data-target-input="nearest">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="far fa-question-circle"></i>
                                            </div>
                                        </div>
                                        <input class="form-control input-style-2 input-group-left-img" id="password" type="password" name="password" value="" placeholder="Enter your password" readonly onfocus="this.removeAttribute('readonly');" />
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
                                    <label for="con-password">Confirm Password</label>
                                    <div class="input-group input-margin-bottom"  data-target-input="nearest">
                                        <div class="input-group-append">
                                            <div class="input-group-text">
                                                <i class="far fa-question-circle"></i>
                                            </div>
                                        </div>
                                        <input class="form-control input-style-2 input-group-left-img" id="con-password" type="password" name="confirm_password" value="" placeholder="Enter your password again" readonly onfocus="this.removeAttribute('readonly');" />
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 input-margin-bottom">
                                    <label class="form-label" for="fitness-goals">Fitness Goals (Optional)</label>
                                    <select name="fitness_goal[]" class="form-control input-style-2 multiSelectInput selectpicker" multiple="multiple" id="fitness-goals">
                                        <option value="">Select Fitness Goals</option>
                                        <option value="Weight Loss">Weight Loss</option>
                                        <option value="Gain Muscle">Gain Muscle</option>
                                        <option value="Athelate Shape">Athelate Shape</option>
                                        <option value="Just fit">Just fit</option>
                                    </select>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 input-margin-bottom">
                                    <label class="form-label" for="health-conditions">Health Condition (Optional)</label>
                                    <textarea class="form-control input-style-2 textareaInput" id="health-conditions" name="health_condition"></textarea>
                                </div>
                                <div class="col-xl-12 col-lg-6 col-md-6 col-xs-6">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input" id="agree" name="agree" value="agreed">
                                        <label class="form-check-label" for="agree">I agree to the Terms and Conditions.</label>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12 submitBtnDiv">
                                    <button class="form-control ind_btn_2" type="submit" style="line-height: 40px;">
                                        <span>
                                            Create Account
                                        </span>
                                    </button>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12" style="margin: 15px 0; text-align: center;">
                                    <p>Already have an acoount? <a href="login.php" target="">Login</a></p>
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
    $(document).ready(function() {
        $('#fitness-goals').select2();
    });
    document.addEventListener("DOMContentLoaded", function () {
        setTimeout(() => {
            let email = document.getElementById("email");
            let password = document.getElementById("password");
            let conPassword = document.getElementById("con-password");

            if (email) {
                email.value = "";
                email.setAttribute("autocomplete", "off");
            }

            if (password) {
                password.value = "";
                password.setAttribute("autocomplete", "new-password");
            }

            if (conPassword) {
                conPassword.value = "";
                conPassword.setAttribute("autocomplete", "new-password");
            }
        }, 100); // Clears autofilled values after 0.5s
    });
</script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("signupForm").addEventListener("submit", function(e) {
            e.preventDefault(); // Prevent form from refreshing the page

            let formData = new FormData(this);

            fetch("http://localhost/legym/user/production/signup_process.php", {
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
                        showConfirmButton: false,
                        timer: 2000
                    }).then(() => {
                        window.location.href = data.redirect; // Redirect to dashboard
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: data.message
                    });
                }
            })
            .catch(error => console.error("Error:", error));
        });
    });
</script>