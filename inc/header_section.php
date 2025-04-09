<header class="header_02" id="fix_nav">
    <div class="header-container">
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-12">
                <div class="logo_02">
                    <div class="mobileMenuBar" style="float: left; width: auto; margin-top: 5px;">
                        <a href="javascript: void(0);" class="menu-bar" style="padding: 0 3px; height: auto;">
                            <i class="fa fa-bars" style="font-size: 25px;"></i>
                        </a>
                    </div>
                    <a href="index.php"><img src="src/img/leGym.png" alt="" style="padding: 5px 0 0 11px; margin-top: 2px;" /></a>
                </div>
                <div class="mobileMenuBar">
                    <?php
                        if(isset($_SESSION['user_id'])) {
                            $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
                            echo '<a href="user/production/dashboard.php" style="font-size: 13px;">
                                    <img src="user/production/images/user.jpg" style="width: 40px; height: 40px; margin-right: 10px;" alt="" class="">'
                                    .$fullname.
                                 '</a>';
                        } else {
                            echo '<a href="login.php" class="ind_btn_3 text-center"><span>Login</span></a>
                                <a href="signup.php" class="ind_btn_3 text-center"><span>Sign Up</span></a>';
                        }
                    ?>
                    <!-- <a href="javascript: void(0);" class="menu-bar"><i class="fa fa-bars"></i></a> -->
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-12">
                <nav class="mainmenu text-center">
                    <ul>
                        <li class="<?php echo $_SERVER['PHP_SELF'] == '/legym/index.php' ? 'current-menu-item' : ''; ?>"><a href="index.php">Home</a></li>
                        <li class="<?php echo $_SERVER['PHP_SELF'] == '/legym/schedules.php' ? 'current-menu-item' : ''; ?>"><a href="schedules.php" target="_blank">Schedule</a></li>
                        <li class="<?php echo $_SERVER['PHP_SELF'] == '/legym/announcements.php' ? 'current-menu-item' : ''; ?>"><a href="announcements.php" target="_blank">Announcements</a></li>
                        <li class="<?php echo $_SERVER['PHP_SELF'] == '/legym/contact_us.php' ? 'current-menu-item' : ''; ?>"><a href="contact_us.php">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 col-lg-3 text-right col-md-12 desktop">
                <?php
                    if(isset($_SESSION['user_id'])) {
                        $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
                        echo '<a href="user/production/dashboard.php" style="display: block; margin: 10px 0; font-size: 13px;">
                                <img src="user/production/images/user.jpg" style="width: 40px; height: 40px; margin-right: 10px;" alt="..." class="">'
                                .$fullname.
                              '</a>';
                    } else {
                        echo '<a href="login.php" class="ind_btn_3 text-center" style="height: 45px;">
                                <span style="bottom: 2px;">Login</span>
                              </a>
                              <a href="signup.php" class="ind_btn_2 text-center" style="height: 45px;">
                                <span style="bottom: 2px;">Sign Up</span>
                              </a>';
                    }
                ?>
            </div>
        </div>
    </div>
</header>