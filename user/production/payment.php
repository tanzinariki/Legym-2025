<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
} else {
    header("Location: http://localhost/legym/login.php");
    exit;
}

require_once "db_connect.php"; // Include your database connection file

// Query to get the Member Plans
$qr = "SELECT *  
        FROM membership_plan";

$qr = $conn->prepare($qr);
$qr->execute();
$res = $qr->get_result();

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
                    <h3>Complete Your Membership</h3>
                    <h5>Update or renew your membership information.</h5>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Choose your plan and payment method.</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="pay-form" data-parsley-validate class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 15px;">
                                        Select Membership Plan <span class="required">*</span>
                                    </label>
                                    <?php
                                    if ($res->num_rows > 0) {
                                        $i = 1;
                                        while ($membership_plan = $res->fetch_assoc()) {
                                            echo '<input class="member-select-radio" type="radio" name="membership_plan_id" id="plan-name-'.$i.'" value="'.$membership_plan['id'].'">';
                                            echo '<label for="plan-name-'.$i.'" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">';
                                            echo '<div class="x_content membership-plan-card">';
                                            echo '<p style="font-weight: bold;">'.$membership_plan['plan_name'].'</p>';
                                            echo '<p class="plan-cost">'.$membership_plan['plan_cost'].'$</p>';
                                            echo '<span>per month</span>';
                                            echo '</div>';
                                            echo '</label>';
                                            echo '<input type="hidden" id="pn'.$i.'" value="'.$membership_plan['plan_name'].'">';
                                            echo '<input type="hidden" id="pc'.$i.'" value="'.$membership_plan['plan_cost'].'">';
                                            $i++;
                                        }
                                    }
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        Payment Method <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="radio payment-method">
                                            <label>
                                                <input type="radio" checked class="flat" name="pay-method" id="pay-method-1" value="card" />
                                                Debit/Credit Card
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="card-no">
                                        Card Number <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input 
                                            type="text" 
                                            id="card-no" 
                                            name="card_number"
                                            required="required"
                                            class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12" 
                                            data-inputmask="'mask' : '9999-9999-9999-9999'"
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="card-expire" style="padding: 8px 0 0;">
                                        Expire At <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                                        <input 
                                            type="text" 
                                            id="card-expire" 
                                            name="card_expire_date"
                                            required="required"
                                            class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12" 
                                            data-inputmask="'mask' : '99/99'"
                                        />
                                    </div>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="card-cvv" style="padding: 8px 0 0;">
                                        CVV <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="padding: 0;">
                                        <input 
                                            type="text" 
                                            id="card-cvv" 
                                            name="card_cvv"
                                            required="required"
                                            class="form-control col-lg-12 col-md-12 col-sm-12 col-xs-12" 
                                            data-inputmask="'mask' : '9999'"
                                        />
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p class="lead" style="font-size: 15px; font-weight: bold; margin: 10px 0;">Order Summary</p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <th style="width:50%" id="p_name">Plan Name</th>
                                                    <td style="text-align: right;" id="p_cost">00.00 $</td>
                                                </tr>
                                                <tr>
                                                    <th>Tax (9.99%)</th>
                                                    <td style="text-align: right;" id="p_tax">00.00 $</td>
                                                </tr>
                                                <tr style="font-size: 20px; color: #26B99A;">
                                                    <th>Total:</th>
                                                    <td style="text-align: right;"><input type="text" id="p_total" name="total-price" value="00.00" style="border: none; text-align: right;" />$</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox agree-check">
                                            <label>
                                                <input type="checkbox" class="flat" name="agree" id="agree" value="agree" />
                                                I agree to the Terms of Service and Privacy Policy.
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button class="btn btn-success" style="float: left;">Confirm Payment</button>
                                    </div>
                                </div>
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
    $(document).ready(function () {
        $(".member-select-radio").change(function (e) {
            let p_name = $("#pn" + this.value).val();
            let p_cost = parseFloat($("#pc" + this.value).val());
            let p_tax = Math.floor(parseFloat(p_cost) * 0.10 * 100) / 100;
            let p_total = (p_cost + parseFloat(p_tax)).toFixed(2); 
            $("#p_name").html(p_name);
            $("#p_cost").html(p_cost);
            $("#p_tax").html(p_tax);
            $("#p_total").val(p_total);
        });
        $("#pay-form").submit(function (event) {
            event.preventDefault();

            $.ajax({
                type: "POST",
                url: "payment_process.php",
                data: $(this).serialize(),
                dataType: "json",
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "OK"
                        }).then(() => {
                            window.location.href = "legym/user/production/dashboard.php";
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "OK"
                        });
                    
                    }
                }
            });
        });
    });
</script>