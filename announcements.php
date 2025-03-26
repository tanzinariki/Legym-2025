<?php
session_start();
require_once 'inc/header.php';
require_once 'inc/preload.php';
require_once 'inc/header_section.php';
?>

        <section id="" class="announcement-head-section mrt-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 offset-lg-1 col-lg-10 offset-lg-1 col-md-12 col-xs-12">
                        <div class="announcement-head-card">
                            <h3>Announcement</h3>
                            <p>
                            Welcome to the Le Gym Announcements page! 
                            Stay updated with the latest news, special events, schedule changes, and exciting offers. 
                            Whether it’s new classes, maintenance updates, or special promotions, you’ll find all the important information here
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="" class="current-announcement-section mrt-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 offset-lg-1 col-lg-10 offset-lg-1 col-md-12 col-xs-12">
                        <div class="current-announcement-card">
                            <h5>Current Announcement</h5>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <div class="announcement-card mrb-20">
                                        <div class="announcement-desc">
                                            <p class="announcement-name mrb-5">Temporary Pool Class</p>
                                            <p class="announcement-detail mrb-5">The swimming pool will be closed for maintenance from March 28-30, 2025. We apologize for any inconvenience.</p>
                                            <p class="announcement-date">Posted on <span>March 25, 2025</span></p>
                                        </div>
                                        <div class="announcement-urgency">
                                            <button class="btn btn-info btn-sm announcement-urgent-btn">Urgent</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <div class="announcement-card mrb-20">
                                        <div class="announcement-desc">
                                            <p class="announcement-name mrb-5">New Yoga Class Added</p>
                                            <p class="announcement-detail mrb-5">We're excited to announce new morning yoga classes starting next week. Check the schedule for details.</p>
                                            <p class="announcement-date">Posted on <span>March 26, 2025</span></p>
                                        </div>
                                        <div class="announcement-urgency">
                                            <button class="btn btn-info btn-sm announcement-normal-btn">Normal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                     
                    </div>
                </div>
            </div>
        </section>

        <section id="" class="post-announcement-section mrt-30 mrb-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 offset-lg-1 col-lg-10 offset-lg-1 col-md-12 col-xs-12">
                        <div class="post-announcement-card">
                            <h5>Past Announcements</h5>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <div class="table-responsive">
                                        <table class="table post-announcement-table">
                                            <thead>
                                                <tr>
                                                    <th>Title</th>
                                                    <th>Description</th>
                                                    <th>Urgency</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Holiday Hours Update</td>
                                                    <td>Modified operating hours for upcoming holidays</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm announcement-normal-btn">Normal</button>
                                                    </td>
                                                    <td>Feb 28, 2025</td>
                                                </tr>
                                                <tr>
                                                    <td>Equipment Upgrade</td>
                                                    <td>New cardio machines installed in Zone 2</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm announcement-normal-btn">Normal</button>
                                                    </td>
                                                    <td>Feb 15, 2025</td>
                                                </tr>
                                                <tr>
                                                    <td>Emergency Exit Maintenance</td>
                                                    <td>Temporary closure of emergency exit B</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm announcement-urgent-btn">Urgent</button>
                                                    </td>
                                                    <td>Feb 1, 2025</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

<?php
require_once 'inc/footer_section.php';
require_once 'inc/copyright_section.php';
require_once 'inc/footer.php';
?>