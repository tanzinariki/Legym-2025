<div class="top_nav" style="position: fixed; z-index: 1000; width: 100%;">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle" style="padding: 5px;"><i class="fa fa-bars"></i></a>
                <a href="../../index.php" class="site_title" style="padding: 5px;"><span>Le Gym</span></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="padding-left: 0;">
                        <img src="images/user.jpg" alt=""><?php echo $fullname ?>
                        <!-- <span class=" fa fa-angle-down"></span> -->
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <!-- <li>
                            <a href="javascript:;"> Profile</a>
                        </li> -->
                        <li>
                            <a href="logout.php">
                                <i class="fa fa-sign-out pull-right"></i> Log Out
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>