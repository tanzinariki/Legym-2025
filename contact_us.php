<?php
session_start();
require_once 'inc/header.php';
require_once 'inc/preload.php';
require_once 'inc/header_section.php';
require_once 'main/contact_us_section.php';
require_once 'inc/footer_section.php';
require_once 'inc/copyright_section.php';
require_once 'inc/footer.php';
?>
<script>
    $(document).ready(function () {
        function field_require(field_id, msg) {
            Swal.fire({
                title: "Missing Field!",
                text: msg,
                icon: "error",
                confirmButtonText: "OK",
                returnFocus: false
            }).then(function() {
                Swal.close();
                $('#'+field_id).focus();
            });
        }

        $("#contactForm").submit(function (event) {
            event.preventDefault();

            let con_name = $("#con_name").val();
            let con_email = $("#con_email").val();
            let con_message = $("#con_message").val();

            if(con_name == '') {
                field_require('con_name', 'You must provide your name!');
                return;
            }
            if(con_email == '') {
                field_require('con_email', 'You must provide your valid email!');
                return;
            }
            if(con_message == '') {
                field_require('con_message', 'You must write something to us!');
                return;
            }

            Swal.fire({
                title: "Message Sent!",
                text: 'We will get back to you soon!',
                icon: "success",
                confirmButtonText: "OK"
            }).then(() => {
                Swal.close();
                location.reload();
            });

            // $.ajax({
            //     type: "POST",
            //     url: "payment_process.php",
            //     data: $(this).serialize(),
            //     dataType: "json",
            //     success: function (response) {
            //         if (response.status === "success") {
            //             Swal.fire({
            //                 title: "Success!",
            //                 text: response.message,
            //                 icon: "success",
            //                 confirmButtonText: "OK"
            //             }).then(() => {
            //                 window.location.href = "dashboard.php";
            //             });
            //         } else {
            //             Swal.fire({
            //                 title: "Error!",
            //                 text: response.message,
            //                 icon: "error",
            //                 confirmButtonText: "OK"
            //             });
                    
            //         }
            //     }
            // });
        });
    });
</script>