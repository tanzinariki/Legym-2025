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
                                            <button class="btn btn-success btn-sm">Active</button>
                                            <p>Plan Name</p>
                                            <p>29.99$ /month</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="x_content membership-date-card">
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding: 0;">
                                                <p class="heading">Start Date</p>
                                                <p>April 1, 2025</p>
                                            </div>
                                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" style="padding: 0;">
                                                <p class="heading">End Date</p>
                                                <p>March 31, 2026</p>
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
                                            <li><img src="images/membership-info/circle-tick.png" />Unlimited access to all gym facilities.</li>
                                            <li><img src="images/membership-info/circle-tick.png" />4 free personal training session per month.</li>
                                            <li><img src="images/membership-info/circle-tick.png" />Access to premium fitness classes.</li>
                                            <li><img src="images/membership-info/circle-tick.png" />Spa access included.</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" style="font-size: 15px; margin-top: 15px;">
                                    Current Discount
                                </label>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="x_content reward-card">
                                        <img src="images/membership-info/tag.png" />
                                        <span>20% off</span>
                                        <p>Pro Shop Items</p>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
                                    <div class="x_content reward-card">
                                        <img src="images/membership-info/tag.png" />
                                        <span>15% off</span>
                                        <p>Nutrition Products</p>
                                    </div>
                                </div>
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