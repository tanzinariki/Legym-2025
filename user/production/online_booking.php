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
                    <h3>Book Your Online Fitness Class</h3>
                    <h5>Select your preferred class and time slot to select your spot.</h5>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Find Your Available Online Classes</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <form id="online-class-booking-form" data-parsley-validate class="form-horizontal form-label-left">
                                <!-- <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="first-name">
                                        First Name <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <input 
                                            type="text" 
                                            id="first-name" 
                                            required="required" 
                                            class="form-control col-lg-12 col-md-7 col-sm-12 col-xs-12"
                                        />
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="class-name">
                                        Online Class <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select 
                                            class="form-control col-lg-12 col-md-7 col-sm-12 col-xs-12 select2-single" 
                                            id="class-name" 
                                            name="class-name"
                                        >
                                            <option value="">Select Online Class</option>
                                            <option value="">1</option>
                                            <option value="">2</option>
                                            <option value="">3</option>
                                            <option value="">4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="datepicker-readonly">
                                        Choose Until When (From Today Onward) <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="input-group date" id='datepicker-readonly'>
                                        <input type='text' class="form-control" readonly="readonly" />
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <button type="submit" class="btn btn-success" style="float: right;">Show</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Available Online Class List</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">
                                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon" style="top: 12px; right: 70px;">
                                            <button type="submit" class="btn btn-success">Reserve</button>
                                        </div>
                                        <div class="count green-font">5</div>
                                        <p class="small-card green-font">Seats Available</p>

                                        <h3>Flow State Yoga</h3>
                                        <p class="font-style-1">With - Yoga Daddy</p>
                                        <p>Mar 26, 2025</p>
                                        <p style="margin-top: 0;">09:00 AM</p>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon" style="top: 12px; right: 70px;">
                                            <button type="submit" class="btn btn-success">Reserve</button>
                                        </div>
                                        <div class="count green-font">17</div>
                                        <p class="small-card green-font">Seats Available</p>

                                        <h3>Flow State Yoga</h3>
                                        <p class="font-style-1">With - Yoga Daddy</p>
                                        <p>Mar 26, 2025</p>
                                        <p style="margin-top: 0;">09:00 AM</p>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon" style="top: 12px; right: 70px;">
                                            <button type="submit" class="btn btn-danger">Booked</i></button>
                                        </div>
                                        <div class="count red-font">0</div>
                                        <p class="small-card red-font">Seats Available</p>

                                        <h3>Flow State Yoga</h3>
                                        <p class="font-style-1">With - Yoga Daddy</p>
                                        <p>Mar 26, 2025</p>
                                        <p style="margin-top: 0;">09:00 AM</p>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon" style="top: 12px; right: 70px;">
                                            <button type="submit" class="btn btn-success">Reserve</button>
                                        </div>
                                        <div class="count green-font">1</div>
                                        <p class="small-card green-font">Seats Available</p>

                                        <h3>Flow State Yoga</h3>
                                        <p class="font-style-1">With - Yoga Daddy</p>
                                        <p>Mar 26, 2025</p>
                                        <p style="margin-top: 0;">09:00 AM</p>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon" style="top: 12px; right: 70px;">
                                            <button type="submit" class="btn btn-success">Reserve</button>
                                        </div>
                                        <div class="count green-font">8</div>
                                        <p class="small-card green-font">Seats Available</p>

                                        <h3>Flow State Yoga</h3>
                                        <p class="font-style-1">With - Yoga Daddy</p>
                                        <p>Mar 26, 2025</p>
                                        <p style="margin-top: 0;">09:00 AM</p>
                                    </div>
                                </div>
                                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
                                    <div class="tile-stats">
                                        <div class="icon" style="top: 12px; right: 70px;">
                                            <button type="submit" class="btn btn-success">Reserve</button>
                                        </div>
                                        <div class="count green-font">15</div>
                                        <p class="small-card green-font">Seats Available</p>

                                        <h3>Flow State Yoga</h3>
                                        <p class="font-style-1">With - Yoga Daddy</p>
                                        <p>Mar 26, 2025</p>
                                        <p style="margin-top: 0;">09:00 AM</p>
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