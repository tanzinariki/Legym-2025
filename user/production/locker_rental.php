<?php
session_start();

// Ensure user is logged in.
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}

if (isset($_SESSION['first_name'], $_SESSION['last_name'])) {
    $fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
} else {
    $fullname = "Guest";
}

require_once 'inc/header.php';
require_once 'db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Locker Rental</title>
  <!-- Include CSS files -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet">
  <link href="css/datetimepicker.min.css" rel="stylesheet">
  <style>
    .required { color: red; }
    /* Styling for the booking form and tabs */
    #bookingForm { margin-top: 20px; }
    .booking-card {
      border: 1px solid #ccc;
      padding: 15px;
      background-color: #f9f9f9;
      margin-bottom: 15px;
      position: relative;
    }
    .booking-card h5 { margin-top: 0; }
    .cancel-booking {
      position: absolute;
      top: 10px;
      right: 10px;
      border: none;
      background-color: #d9534f;
      color: #fff;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 3px;
    }
    .section-heading { margin-top: 20px; border-bottom: 2px solid #ddd; padding-bottom: 5px; }
  </style>
</head>
<body>
<div class="container body">
  <div class="main_container">
    <!-- Sidebar -->
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <?php 
          require_once 'inc/top_left_nav.php';
          require_once 'inc/menu_profile.php';
          require_once 'inc/sidebar.php';
        ?>
      </div>
    </div>
    <!-- Top Navigation -->
    <?php require_once 'inc/top_nav.php'; ?>

    <!-- Page Content -->
    <div class="right_col" role="main">
      <!-- Booking Form -->
      <div id="bookingForm" class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Book Your Locker</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form id="locker-rental-form" method="POST" class="form-horizontal form-label-left">
                <!-- Date Picker -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="rental_date">Date <span class="required">*</span></label>
                  <div class="col-lg-12">
                    <div class="input-group date" id="datepicker-readonly">
                      <input type="text" class="form-control" name="date" id="rental_date" readonly="readonly" required />
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Time Slot Selection -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="time-slot">Time Slot <span class="required">*</span></label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="time-slot" name="time-slot" required>
                      <option value="">Select Your Time Slot</option>
                      <option value="09:00 AM - 11:00 AM">09:00 AM - 11:00 AM</option>
                      <option value="11:00 AM - 01:00 PM">11:00 AM - 01:00 PM</option>
                      <option value="01:00 PM - 03:00 PM">01:00 PM - 03:00 PM</option>
                      <option value="03:00 PM - 05:00 PM">03:00 PM - 05:00 PM</option>
                      <option value="05:00 PM - 07:00 PM">05:00 PM - 07:00 PM</option>
                      <option value="07:00 PM - 09:00 PM">07:00 PM - 09:00 PM</option>
                    </select>
                  </div>
                </div>
                <!-- Locker Selection -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="locker-no">Locker <span class="required">*</span></label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="locker-no" name="locker-no" required>
                      <option value="">Select Date &amp; Time First</option>
                    </select>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <!-- Submit Button -->
                <div class="form-group">
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-success" style="float: right;">Rent Locker</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- Bookings Tabs -->
      <div id="bookingsGrid">
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#upcoming">Upcoming Bookings</a></li>
          <li><a data-toggle="tab" href="#past">Past Bookings</a></li>
        </ul>
        <div class="tab-content" style="margin-top:15px;">
          <div id="upcoming" class="tab-pane fade in active">
            <div id="upcomingBookingsContainer" class="row">
              <div class="col-md-12"><p>No upcoming bookings.</p></div>
            </div>
          </div>
          <div id="past" class="tab-pane fade">
            <div id="pastBookingsContainer" class="row">
              <div class="col-md-12"><p>No past bookings.</p></div>
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

<!-- Include JS libraries -->
<script src="js/jquery.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/datetimepicker.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
  var availableLockers = [];
  // Array to store all bookings for the user.
  var allBookings = [];
  
  // Initialize plugins.
  $('.select2-single').select2();
  $('#datepicker-readonly').datetimepicker({
      format: 'MMM DD, YYYY',
      ignoreReadonly: true,
      allowInputToggle: true,
      minDate: new Date()  // Disable past dates.
  });
  
  // When date or time slot changes, reload available lockers and bookings.
  $('#rental_date, #time-slot').on('change', function() {
    loadAvailableLockers();
    loadBookings();
  });
  
  // Load available lockers.
  function loadAvailableLockers() {
    var selectedDate = $('#rental_date').val();
    var selectedTimeSlot = $('#time-slot').val();
    availableLockers = [];
    
    if (selectedDate && selectedTimeSlot) {
      $.ajax({
        url: 'locker_rental_process.php',
        type: 'GET',
        dataType: 'json',
        data: {
          action: 'get_available_lockers',
          date: selectedDate,
          time_slot: selectedTimeSlot
        },
        success: function(response) {
          var lockerSelect = $('#locker-no');
          lockerSelect.empty();
          if (response.status === 'success') {
            availableLockers = response.data;
            if (availableLockers.length > 0) {
              lockerSelect.append('<option value="">Select a Locker</option>');
              $.each(availableLockers, function(index, locker) {
                lockerSelect.append('<option value="' + locker.id + '">' + locker.locker_name + '</option>');
              });
            } else {
              lockerSelect.append('<option value="">No Lockers Available</option>');
            }
          } else {
            lockerSelect.append('<option value="">' + response.message + '</option>');
          }
        },
        error: function() {
          // Silent error.
        }
      });
    }
  }
  
  // Load all bookings for the logged-in user.
  function loadBookings() {
    $.ajax({
      url: 'locker_rental_process.php',
      type: 'GET',
      dataType: 'json',
      data: { action: 'get_bookings' },
      success: function(response) {
        if (response.status === 'success') {
          allBookings = response.data; // Each booking includes booking_id, rent_date, rent_duration, locker_name.
          renderBookings();
        }
      },
      error: function() {
        // Silent error.
      }
    });
  }
  
  // Render bookings into Upcoming and Past tabs.
  function renderBookings() {
    var containerUpcoming = $('#upcomingBookingsContainer');
    var containerPast = $('#pastBookingsContainer');
    containerUpcoming.empty();
    containerPast.empty();
    
    var today = new Date();
    today.setHours(0,0,0,0);
    
    // Upcoming bookings: those with rent_date >= today.
    var upcomingBookings = allBookings.filter(function(booking) {
      var bDate = new Date(booking.rent_date + 'T00:00:00');

      return bDate >= today;
    });
    
    // Past bookings: those with rent_date < today.
    var pastBookings = allBookings.filter(function(booking) {
      var bDate = new Date(booking.rent_date + 'T00:00:00');

      return bDate < today;
    });
    
    if (upcomingBookings.length > 0) {
      $.each(upcomingBookings, function(index, booking) {
        var card = `
          <div class="col-md-4">
            <div class="booking-card">
              <button class="cancel-booking" data-booking-id="${booking.booking_id}">Cancel</button>
              <h5>Locker ${booking.locker_name}</h5>
              <p><strong>ID:</strong> ${booking.booking_id}</p>
              <p><strong>Date:</strong> ${booking.rent_date}</p>
              <p><strong>Time Slot:</strong> ${booking.rent_duration}</p>
            </div>
          </div>
        `;
        containerUpcoming.append(card);
      });
    } else {
      containerUpcoming.append('<div class="col-md-12"><p>No upcoming bookings for this date and time.</p></div>');
    }
    
    if (pastBookings.length > 0) {
      $.each(pastBookings, function(index, booking) {
        var card = `
          <div class="col-md-4">
            <div class="booking-card">
              <h5>Locker ${booking.locker_name}</h5>
              <p><strong>ID:</strong> ${booking.booking_id}</p>
              <p><strong>Date:</strong> ${booking.rent_date}</p>
              <p><strong>Time Slot:</strong> ${booking.rent_duration}</p>
            </div>
          </div>
        `;
        containerPast.append(card);
      });
    } else {
      containerPast.append('<div class="col-md-12"><p>No past bookings.</p></div>');
    }
  }
  
  // Submit booking form.
  $('#locker-rental-form').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
      url: 'locker_rental_process.php',
      type: 'POST',
      dataType: 'json',
      data: $(this).serialize(),
      success: function(response) {
        if (response.status === 'success') {
          // Add new booking to allBookings.
          allBookings.push({
            booking_id: response.data.booking_id,
            locker_name: response.data.locker_name,
            rent_date: response.date,
            rent_duration: response.time_slot
          });
          renderBookings();
          loadAvailableLockers();
        }
      },
      error: function() {
        // Silent error.
      }
    });
  });
  
  // Cancel booking.
  $('#upcomingBookingsContainer').on('click', '.cancel-booking', function() {
    var bookingId = $(this).data('booking-id');
    var booking = allBookings.find(function(b) { return b.booking_id == bookingId; });
    if (booking) {
      $.ajax({
        url: 'locker_rental_process.php',
        type: 'GET',
        dataType: 'json',
        data: { action: 'remove_booking', booking_id: booking.booking_id },
        success: function(response) {
          if (response.status === 'success') {
            allBookings = allBookings.filter(function(b) { return b.booking_id != booking.booking_id; });
            renderBookings();
            loadAvailableLockers();
          }
        },
        error: function() {
          // Silent error.
        }
      });
    }
  });
  
  // Initial load.
  loadAvailableLockers();
  loadBookings();
});
</script>
</body>
</html>
