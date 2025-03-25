<?php
require_once 'user/production/db_connect.php';
// Query to get the Member Plans
$sql = 'SELECT * FROM membership_plan';
$qr = $conn->prepare($sql);
$qr->execute();
$res_membership_plan = $qr->get_result();
?>
<section id="memberships" class="commonSection">
    <div class="container">
        <div class="row">
            <div class="col-xl-12 text-center">                        
                <h2 class="sec_title with_bar">
                    <span><span>Simple, Transparent Pricing</span></span>
                </h2>
                <h6 class="sub_title gray_sub_title" style="line-height: 25px;">Choose the plan that fits your fitness goals</h6>
            </div>
        </div>
        <div class="row">
            <?php
            // if ($res_membership_plan->num_rows > 0) {
            //     $i = 1;
            //     while ($membership_plan = $res_membership_plan->fetch_assoc()) {
            //         echo '<div class="col-xl-4 col-lg-6 col-md-6 col-xs-12 d-flex">';
            //         echo '<div class="membershipDetail equal-height">';
            //         echo '<h4 class="planName">'.$membership_plan['plan_name'].'</h4>';
            //         echo '<p class="planPrice">'.$membership_plan['plan_cost'].'$<span class="slashStyle">/</span><span class="smallSpan">month</span></p>';
            //         echo '<ul>';
            //         $benefits = explode('|', $membership_plan['plan_benefit']);
            //         foreach ($benefits as $benefit) {
            //             echo '<li>';
            //             echo '<img src="src/img/services/tick.png" alt="" class="tickImg" />';
            //             echo '<span class="planFeature">'.$benefit.'</span>';
            //             echo '</li>';
            //         }
            //         echo '</ul>';
            //         echo '<a href="#" class="ind_btn_membership"><span>Choose Plan</span></a>';
            //         echo '</div>';
            //         echo '</div>';
            //         $i++;
            //     }
            // }
            ?>
            <div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
                <div class="membershipDetail">
                    <h4 class="planName">Basic</h4>
                    <p class="planPrice">29.99$<span class="slashStyle">/</span><span class="smallSpan">month</span></p>
                    <ul>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Access to gym facilities</span>
                        </li>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Basic fitness classes</span>
                        </li>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Locker rental</span>
                        </li>
                    </ul>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a href="user/production/payment.php" class="ind_btn_membership"><span>Choose Plan</span></a>';
                    } else {
                        echo '<a href="user/production/dashboard.php" class="ind_btn_membership"><span>Choose Plan</span></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 col-xs-12">
                <div class="membershipDetail">
                    <h4 class="planName">Elite</h4>
                    <p class="planPrice">59.99$<span class="slashStyle">/</span><span class="smallSpan">month</span></p>
                    <ul>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">All Basic Features</span>
                        </li>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Personal Training Session</span>
                        </li>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Premium Classes</span>
                        </li>
                    </ul>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a href="user/production/payment.php" class="ind_btn_membership"><span>Choose Plan</span></a>';
                    } else {
                        echo '<a href="user/production/dashboard.php" class="ind_btn_membership"><span>Choose Plan</span></a>';
                    }
                    ?>
                </div>
            </div>
            <div class="col-xl-4 offset-xl-0 col-lg-6 offset-lg-0 col-md-6 offset-md-3 col-xs-12">
                <div class="membershipDetail">
                    <h4 class="planName">Premium</h4>
                    <p class="planPrice">79.99$<span class="slashStyle">/</span><span class="smallSpan">month</span></p>
                    <ul>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">All Elite Features</span>
                        </li>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Unlimited Personal Training Sessions</span>
                        </li>
                        <li>
                            <img src="src/img/services/tick.png" alt="" class="tickImg" />
                            <span class="planFeature">Guest Passes</span>
                        </li>
                    </ul>
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<a href="user/production/payment.php" class="ind_btn_membership"><span>Choose Plan</span></a>';
                    } else {
                        echo '<a href="user/production/dashboard.php" class="ind_btn_membership"><span>Choose Plan</span></a>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>