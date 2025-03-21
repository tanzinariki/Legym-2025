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
            <?php
            require_once 'inc/top_left_nav.php';
            ?>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <?php
            require_once 'inc/menu_profile.php';
            ?>
            <!-- /menu profile quick info -->
            <br />
            <!-- sidebar menu -->
            <?php
            require_once 'inc/sidebar.php';
            ?>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <?php
        require_once 'inc/top_nav.php';
        ?>
        <!-- /top navigation -->



        

        <!-- page content -->
        <div class="right_col" role="main">
            
        </div>
        <!-- /page content -->






        <!-- footer content -->
        <?php
        require_once 'inc/copyright.php';
        ?>
        <!-- /footer content -->
      </div>
    </div>
<?php
require_once 'inc/footer.php';
?>