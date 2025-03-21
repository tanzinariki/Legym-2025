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
                    <h3>Book In-Person Fitness Session Schedule</h3>
                    <h5>Join our in-person fitness events and transform your fitness journey with expert guidance and motivating group sessions.</h5>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Find Your Available Fitness Session</h2>
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
                                    <label class="control-label col-lg-12 col-md-12 col-sm-12 col-xs-12" for="class-name">
                                        Fitness Session <span class="required">*</span>
                                    </label>
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <select 
                                            class="form-control col-lg-12 col-md-7 col-sm-12 col-xs-12 select2-single" 
                                            id="class-name" 
                                            name="class-name"
                                        >
                                            <option value="">Select Session</option>
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
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Fitness Session Result List</h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li>
                                    <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <article class="media event">
                                <a class="pull-left date">
                                    <p class="month">March</p>
                                    <p class="day">28</p>
                                </a>
                                <a class="pull-right">
                                    <button type="submit" class="btn btn-success">Book</button>
                                </a>
                                <div class="media-body">
                                    <span class="label label-primary label-training-session">Training Session</span>
                                    <p class="font-style-3">HIIT Workout Masterclass</p>
                                    <p class="font-style-1">With - Yoga Daddy</p>
                                    <span>09:00 AM</span>
                                </div>
                            </article>
                            <article class="media event">
                                <a class="pull-left date">
                                    <p class="month">March</p>
                                    <p class="day">30</p>
                                </a>
                                <a class="pull-right">
                                    <button type="submit" class="btn btn-danger">Cancel</button>
                                </a>
                                <div class="media-body">
                                    <span class="label label-primary label-workshop">Workshop</span>
                                    <p class="font-style-3">Nutrtion & Meal Planning</p>
                                    <p class="font-style-1">With - Yoga Daddy</p>
                                    <span>09:00 AM</span>
                                </div>
                            </article>
                            <article class="media event">
                                <a class="pull-left date">
                                    <p class="month">March</p>
                                    <p class="day">30</p>
                                </a>
                                <a class="pull-right">
                                    <button type="submit" class="btn btn-success">Book</button>
                                </a>
                                <div class="media-body">
                                    <span class="label label-primary label-special-event">Special Event</span>
                                    <p class="font-style-3">Yoga & Meditation Retreat</p>
                                    <p class="font-style-1">With - Yoga Daddy</p>
                                    <span>09:00 AM</span>
                                </div>
                            </article>
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