<?php
require_once __DIR__ . '/inc/header.php';
require_once __DIR__ . '/inc/preload.php';
?>
<section class="sectionStyle">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 offset-xl-4 col-lg-4 offset-lg-4 col-md-6 offset-md-3 col-xs-12 forgotPassword">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-12 text-center forgotPasswordHead">
                            <h2><a href="index.php"><span>Le Gym</span></a></h2>
                            <p class="subTitle">Reset your password</p>
                        </div>
                        <div class="forgotPasswordForm">
                            <form id="forgotPasswordForm" method="post" action="forgot_password_process.php" class="row">
                                <div class="col-xl-12">
                                    <label for="email">Email Address</label>
                                </div>
                                <div class="col-xl-12 input-group input-margin-bottom" data-target-input="nearest">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <i class="far fa-envelope"></i>
                                        </div>
                                    </div>
                                    <input class="form-control input-style-2 input-group-left-img" id="email" type="text" name="email" placeholder="Enter your email" autocomplete="off" required />
                                </div>
                                <div class="col-xl-12 submitBtnDiv">
                                    <button class="form-control ind_btn_2" type="submit" style="line-height: 40px;">
                                        <span>
                                            <i class="fas fa-key"></i>
                                            Reset Password
                                        </span>
                                    </button>
                                </div>
                                <div class="col-xl-12" style="margin: 15px 0; text-align: center;">
                                <p><a href="login.php"><i class="fal fa-long-arrow-left" style="margin-right: 10px;"></i>Back to Login</a></p>

                                    <p>© 2025 Le Gym. All rights reserved.</p>
                                </div>
                            </form>
                        </div><!-- .forgotPasswordForm -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Bootstrap Modal for displaying messages -->
<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content">
         <div class="modal-header">
             <h5 class="modal-title" id="responseModalLabel">Message</h5>
             <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">&times;</span>
             </button>
         </div>
         <div class="modal-body" id="responseModalBody"></div>
         <div class="modal-footer">
             <button type="button" class="btn btn-primary" id="modalActionButton">OK</button>
         </div>
     </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Use Fetch API to handle form submission and display a modal message
document.getElementById("forgotPasswordForm").addEventListener("submit", function(e) {
    e.preventDefault();
    let formData = new FormData(this);
    fetch("forgot_password_process.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById("responseModalBody").innerText = data.message;
        $('#responseModal').modal('show');
        document.getElementById("modalActionButton").onclick = function() {
            if(data.status === "success" && data.redirect) {
                window.location.href = data.redirect;
            } else {
                $('#responseModal').modal('hide');
            }
        };
    })
    .catch(error => {
        console.error("Error:", error);
        alert("An unexpected error occurred.");
    });
});
</script>
<?php
require_once __DIR__ . '/inc/footer.php';
?>
