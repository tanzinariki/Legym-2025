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
                    <h3>Join Fitness Challenge</h3>
                    <h5>Let's take the challenge.</h5>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Find Available Locker For Booking/Rent</h2>
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
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="challenge-name">
                                        Challenge <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select 
                                            class="form-control col-lg-12 col-md-7 col-sm-12 col-xs-12 select2-single" 
                                            id="challenge-name" 
                                            name="challenge-name"
                                        >
                                            <option value="">Select Challenge</option>
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                            <option value="">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="time-slot">
                                        Challenge Description
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <textarea 
                                            id="challenge-desc" 
                                            class="form-control readonly-text-area-style-1" 
                                            name="challenge-desc"
                                            readonly 
                                            data-parsley-trigger="keyup" 
                                            data-parsley-minlength="30" 
                                            data-parsley-maxlength="100" 
                                            data-parsley-minlength-message="Come on! You need to enter at least a 20 caracters long comment.." 
                                            data-parsley-validation-threshold="10"
                                        ></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        Members Joined
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <ol style="padding: 10px 15px;">
                                            <li>Tania Sajid</li>
                                            <li>Tanzina Nasrin</li>
                                            <li>Emma Davis</li>
                                        </ol>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        Rewards
                                    </label>
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
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
                                            <img src="images/fitness-challenge/bonus-points.png" />
                                            <p>Bonus Point</p>
                                            <span>Daily Competition</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" class="btn btn-success" style="float: right;">Join Challenge</button>
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
    $(document).ready(function() {
        $('.select2-single').select2();
    });
</script>