<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
} else {
    header("Location: http://localhost/legym/login.php");
    exit;
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
                            <form id="in-person-fitness-form" data-parsley-validate class="form-horizontal form-label-left">
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 15px;">
                                        Select Membership Plan <span class="required">*</span>
                                    </label>
                                    <input class="member-select-radio" type="radio" name="plan-name" id="plan-name-1" value="basic">
                                    <label for="plan-name-1" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="x_content membership-plan-card">
                                            <p style="font-weight: bold;">Basic</p>
                                            <p class="plan-cost">29.99$</p>
                                            <span>per month</span>
                                        </div>
                                    </label>
                                    <input class="member-select-radio" type="radio" name="plan-name" id="plan-name-2" value="basic">
                                    <label for="plan-name-2" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="x_content membership-plan-card">
                                            <p style="font-weight: bold;">Pro</p>
                                            <p class="plan-cost">49.99$</p>
                                            <span>per month</span>
                                        </div>
                                    </label>
                                    <input class="member-select-radio" type="radio" name="plan-name" id="plan-name-3" value="basic">
                                    <label for="plan-name-3" class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                        <div class="x_content membership-plan-card">
                                            <p style="font-weight: bold;">Elite</p>
                                            <p class="plan-cost">79.99$</p>
                                            <span>per month</span>
                                        </div>
                                    </label>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        Payment Method <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="radio payment-method">
                                            <label>
                                                <input type="radio" class="flat" name="pay-method" id="pay-method-1" value="card" />
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
                                            name="card-no"
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
                                            name="card-expire"
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
                                            name="card-cvv"
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
                                                    <th style="width:50%">Plan Name</th>
                                                    <td style="text-align: right;">29.99 $</td>
                                                </tr>
                                                <tr>
                                                    <th>Tax (9.99%)</th>
                                                    <td style="text-align: right;">2.99 $</td>
                                                </tr>
                                                <tr style="font-size: 20px; color: #26B99A;">
                                                    <th>Total:</th>
                                                    <td style="text-align: right;"><input type="text" name="total-price" value="32.98" style="border: none; text-align: right;" />$</td>
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
                                        <a href="payment.php" class="btn btn-success" style="float: left;">Confirm Payment</a>
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