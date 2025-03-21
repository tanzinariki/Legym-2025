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
                    <h3>Locker Rental</h3>
                    <h5>Select your preferred locker and rental duration.</h5>
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
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="datepicker-readonly">
                                        Date <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-group date" id='datepicker-readonly'>
                                        <input type='text' class="form-control" name="date" readonly="readonly" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="time-slot">
                                        Time slots <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select 
                                            class="form-control col-lg-12 col-md-7 col-sm-12 col-xs-12 select2-single" 
                                            id="time-slot" 
                                            name="time-slot"
                                        >
                                            <option value="">Select Your Time Slot</option>
                                            <option value="">09:00 AM - 11:00 AM</option>
                                            <option value="">11:00 AM - 01:00 PM</option>
                                            <option value="">01:00 PM - 03:00 PM</option>
                                            <option value="">03:00 PM - 05:00 PM</option>
                                            <option value="">05:00 PM - 07:00 PM</option>
                                            <option value="">07:00 PM - 09:00 PM</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="locker-no">
                                        Locker <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select 
                                            class="form-control col-lg-12 col-md-7 col-sm-12 col-xs-12 select2-single" 
                                            id="locker-no" 
                                            name="locker-no"
                                        >
                                            <option value="">Select Available Locker</option>
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                            <option value="">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" class="btn btn-success" style="float: right;">Rent Locker</button>
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

        $('#datepicker-readonly').datetimepicker({
            format: 'MMM DD, YYYY',
            ignoreReadonly: true,
            allowInputToggle: true
        });
    });
</script>