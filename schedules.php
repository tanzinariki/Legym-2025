<?php
session_start();
require_once 'inc/header.php';
require_once 'inc/preload.php';
require_once 'inc/header_section.php';
?>

        <section id="" class="gym-status-section mrt-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 offset-lg-1 col-lg-10 offset-lg-1 col-md-12 col-xs-12">
                        <div class="gym-status-card">
                            <h5>Gym Status</h5>
                            <p>
                                <span class="" style="color: green;">
                                    <i class="fas fa-circle mrr-10"></i>
                                    Open Now
                                </span>
                                 | Closes at 10:00 PM
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="" class="operating-hours-section mrt-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 offset-lg-1 col-lg-10 offset-lg-1 col-md-12 col-xs-12">
                        <div class="operating-hours-card">
                            <h5>Operating Hours</h5>
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-xs-12">
                                    <p class="schedule-day-type mrb-5">Weekdays</p>
                                    <div class="schedule-day-card">
                                        <p class="schedule-day">Monday-Friday</p>
                                        <p class="schedule-time">06:00 AM - 10:00 PM</p>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-xs-12">
                                    <p class="schedule-day-type mrb-5">Weekends</p>
                                    <div class="schedule-day-card">
                                        <p class="schedule-day">Saturday</p>
                                        <p class="schedule-time">07:00 AM - 08:00 PM</p>
                                    </div>
                                    <div class="schedule-day-card">
                                        <p class="schedule-day">Sunday</p>
                                        <p class="schedule-time">08:00 AM - 06:00 PM</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section id="" class="holiday-schedule-section mrt-30 mrb-30">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-10 offset-lg-1 col-lg-10 offset-lg-1 col-md-12 col-xs-12">
                        <div class="holiday-schedule-card">
                            <h5>Holiday Schedule 2025</h5>
                            <div class="row">
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <div class="holiday-card mrb-20">
                                        <div class="holiday-desc">
                                            <p class="holiday-name mrb-5">New Year's Day</p>
                                            <p class="holiday-date">January 1, 2025</p>
                                        </div>
                                        <div class="holiday-gym-status">
                                            <button class="btn btn-info btn-sm holiday-closed-btn">Closed</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <div class="holiday-card mrb-20">
                                        <div class="holiday-desc">
                                            <p class="holiday-name mrb-5">Memorial Day</p>
                                            <p class="holiday-date">May 26, 2025</p>
                                        </div>
                                        <div class="holiday-gym-status">
                                            <button class="btn btn-info btn-sm holiday-limited-hours-btn">09:00 AM - 06:00 PM</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
                                    <div class="holiday-card mrb-20">
                                        <div class="holiday-desc">
                                            <p class="holiday-name mrb-5">Independence Day</p>
                                            <p class="holiday-date">July 4, 2025</p>
                                        </div>
                                        <div class="holiday-gym-status">
                                            <button class="btn btn-info btn-sm holiday-limited-hours-btn">09:00 AM - 06:00 PM</button>
                                        </div>
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