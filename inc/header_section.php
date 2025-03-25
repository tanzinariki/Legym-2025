<header class="header_02" id="fix_nav">
    <div class="header-container">
        <div class="row">
            <div class="col-xl-2 col-lg-2 col-md-12">
                <div class="logo_02">
                    <a href="index.php"><img src="src/img/leGym.png" alt=""/></a>
                </div>
                <div class="mobileMenuBar">
                    <?php
                        if(isset($_SESSION['user_id'])) {
                            $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
                            echo '<a href="user/production/dashboard.php" style="margin-right: 7px;">
                                    <img src="user/production/images/user.jpg" style="width: 40px; height: 40px; margin-right: 5px;" alt="" class="">'
                                    .$fullname.
                                 '</a>';
                        } else {
                            echo '<a href="login.php" class="ind_btn_3 text-center"><span>Login</span></a>
                                <a href="signup.php" class="ind_btn_3 text-center"><span>Sign Up</span></a>';
                        }
                    ?>
                    <a href="javascript: void(0);" class="menu-bar"><i class="fa fa-bars"></i></a>
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
                        echo '<a href="user/production/dashboard.php" style="display: block; margin: 13px 0;">
                                <img src="user/production/images/user.jpg" style="width: 40px; height: 40px; margin-right: 10px;" alt="..." class="">'
                                .$fullname.
                              '</a>';
                    } else {
                        echo '<a href="login.php" class="ind_btn_3 text-center"><span>Login</span></a>
                              <a href="signup.php" class="ind_btn_2 text-center"><span>Sign Up</span></a>';
                    }
                ?>
            </div>
        </div>
    </div>
</header>