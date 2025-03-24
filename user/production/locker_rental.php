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
                      <!-- Using YYYY-MM-DD format -->
                      <input type="text" class="form-control" name="date" id="rental_date" readonly="readonly" required />
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Time Slot Selection (populated dynamically) -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="time-slot">Time Slot <span class="required">*</span></label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="time-slot" name="time-slot" required>
                      <option value="">Select Your Time Slot</option>
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

      <!-- Bookings Grid (Upcoming and Past Bookings) -->
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

<!-- Bootstrap Modal for Success Messages -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="successModalLabel">Success</h4>
      </div>
      <div class="modal-body" id="modalMessage">
        <!-- Success message will be set dynamically -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
      </div>
    </div>
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
  var allBookings = [];

  // Define time slots (each with a label, start, and end in 24-hour format)
  var timeSlots = [
    { label: "09:00 AM - 11:00 AM", start: 9,  end: 11 },
    { label: "11:00 AM - 01:00 PM", start: 11, end: 13 },
    { label: "01:00 PM - 03:00 PM", start: 13, end: 15 },
    { label: "03:00 PM - 05:00 PM", start: 15, end: 17 },
    { label: "05:00 PM - 07:00 PM", start: 17, end: 19 },
    { label: "07:00 PM - 09:00 PM", start: 19, end: 21 }
  ];

  // Initialize plugins.
  $('.select2-single').select2();
  $('#datepicker-readonly').datetimepicker({
      format: 'YYYY-MM-DD', // standard format for JS Date parsing
      ignoreReadonly: true,
      allowInputToggle: true,
      minDate: new Date()  // disable past dates
  });

  // Listen to the dp.change event on the datepicker container.
  $('#datepicker-readonly').on('dp.change', function(e) {
    loadTimeSlots();
    // Reset time slot and locker selections.
    $('#time-slot').val('');
    $('#locker-no').empty().append('<option value="">Select Date &amp; Time First</option>');
  });

  // When a time slot is selected, load available lockers and bookings.
  $('#time-slot').on('change', function() {
    loadAvailableLockers();
    loadBookings();
  });

  // Dynamically populate time slots.
// Helper function to create a local date string in "YYYY-MM-DD" format.
// Helper function to get a local date string "YYYY-MM-DD".
function getLocalDateString(date) {
  var year = date.getFullYear();
  var month = ("0" + (date.getMonth() + 1)).slice(-2);
  var day = ("0" + date.getDate()).slice(-2);
  return year + "-" + month + "-" + day;
}

function loadTimeSlots() {
  var selectedDateStr = $('#rental_date').val().trim();
  console.log("Selected Date:", selectedDateStr);
  
  var timeSlotSelect = $('#time-slot');
  timeSlotSelect.empty();
  timeSlotSelect.append('<option value="">Select Your Time Slot</option>');
  
  if (!selectedDateStr) return;
  
  // Get today's date in local time.
  var now = new Date();
  var todayStr = getLocalDateString(now);
  console.log("Today (local):", todayStr);
  
  var filteredSlots = timeSlots;
  
  // If the selected date is today, filter out slots that have already started.
  if (selectedDateStr === todayStr) {
    var nextHour = now.getHours() + 1;
    console.log("Current Hour:", now.getHours(), "Next Hour:", nextHour);
    filteredSlots = timeSlots.filter(function(slot) {
      return slot.start >= nextHour;
    });
    console.log("Filtered Slots:", filteredSlots);
  }
  
  // Populate the dropdown.
  if (filteredSlots.length === 0) {
    timeSlotSelect.append('<option value="">No time slots available</option>');
  } else {
    $.each(filteredSlots, function(index, slot) {
      timeSlotSelect.append('<option value="' + slot.label + '">' + slot.label + '</option>');
    });
  }
}





  // Load available lockers (AJAX GET).
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
          // Handle error silently.
        }
      });
    }
  }

  // Load bookings for the logged-in user.
  function loadBookings() {
    $.ajax({
      url: 'locker_rental_process.php',
      type: 'GET',
      dataType: 'json',
      data: { action: 'get_bookings' },
      success: function(response) {
        if (response.status === 'success') {
          allBookings = response.data;
          renderBookings();
        }
      },
      error: function() {
        // Handle error silently.
      }
    });
  }

  // Render bookings into "Upcoming" and "Past" tabs.
  function renderBookings() {
    var containerUpcoming = $('#upcomingBookingsContainer');
    var containerPast = $('#pastBookingsContainer');
    containerUpcoming.empty();
    containerPast.empty();
    
    var today = new Date();
    today.setHours(0,0,0,0);
    
    var upcomingBookings = allBookings.filter(function(booking) {
      var bDate = new Date(booking.rent_date + 'T00:00:00');
      return bDate >= today;
    });
    
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
      containerUpcoming.append('<div class="col-md-12"><p>No upcoming bookings.</p></div>');
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
          // Update the bookings grid.
          allBookings.push({
            booking_id: response.data.booking_id,
            locker_name: response.data.locker_name,
            rent_date: response.date,
            rent_duration: response.time_slot
          });
          renderBookings();
          loadAvailableLockers();
          // Show success modal for booking.
          $('#modalMessage').html('Booking Successful!');
          $('#successModal').modal('show');
        }
      },
      error: function() {
        // Handle error silently.
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
            // Show success modal for cancellation.
            $('#modalMessage').html('Cancellation Successful!');
            $('#successModal').modal('show');
          }
        },
        error: function() {
          // Handle error silently.
        }
      });
    }
  });

  // Initial load: if a date is pre-filled, load time slots and bookings.
  loadTimeSlots();
  loadBookings();
});
</script>
</body>
</html>
