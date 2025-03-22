<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}

// Define $fullname before including header or top nav
if (isset($_SESSION['first_name'], $_SESSION['last_name'])) {
    $fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
} else {
    $fullname = "Guest";
}
require_once 'inc/header.php';
require_once 'db_connect.php';

// Fetch active trainers for the booking form.
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
$sql = "SELECT id, trainer_name FROM trainer WHERE status = 'Active'";
$result = $conn->query($sql);
$trainers = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $trainers[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Book Personal Training Session</title>
    <!-- You can use local files or CDN links -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <link href="css/datetimepicker.min.css" rel="stylesheet">
    <style>
        .required { color: red; }
        .label-training-session { margin-right: 5px; }
        /* Hide the entire specialties wrapper by default */
        #specialties-wrapper { display: none; }
    </style>
</head>
<body>
<div class="container body">
  <div class="main_container">
    <!-- Left Sidebar -->
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

    <!-- Page Content -->
    <div class="right_col" role="main">
      <div class="page-title">
        <div class="title_left">
          <h3>Book Personal Training Session</h3>
          <h5>Schedule your one-on-one training session with our expert trainers.</h5>
        </div>
      </div>
      <div class="clearfix"></div>
      
      <!-- Booking Form -->
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Meet Your Preferred Enthusiastic Fitness Trainer</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li>
                  <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form id="in-person-fitness-form" data-parsley-validate class="form-horizontal form-label-left">
                <!-- Trainer Selection -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="trainer-name">
                    Trainer <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="trainer-name" name="trainer_id" required>
                      <option value="">Select Trainer</option>
                      <?php foreach($trainers as $trainer): ?>
                        <option value="<?php echo $trainer['id']; ?>">
                          <?php echo $trainer['trainer_name']; ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- Trainer Specialities Wrapper (hidden by default) -->
                <div class="form-group" id="specialties-wrapper">
                  <label class="control-label col-lg-12">Trainer Specialities</label>
                  <div class="col-lg-12" id="trainer-specialities" style="margin-top: 10px;">
                    <!-- Specialties will be populated here once a trainer is picked -->
                  </div>
                </div>
                <!-- Date Picker -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="datepicker-readonly">
                    Date <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <div class="input-group date" id="datepicker-readonly">
                      <input type="text" class="form-control" name="training_date" id="training_date" readonly="readonly" required />
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
                  </div>
                </div>
                <!-- Available Time Slots -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="available-time-slot">
                    Available Time slots <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="available-time-slot" name="timeslot" required>
                      <option value="">Select Trainer and Date First</option>
                    </select>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <!-- Submit Button -->
                <div class="form-group">
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-success" style="float: right;">Book The Trainer</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Upcoming Sessions Section -->
      <div class="row">
        <div class="col-lg-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Your Upcoming Sessions</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li>
                  <a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                </li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content" id="upcomingSessionsContainer">
              <!-- Upcoming sessions will be loaded via AJAX -->
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

<!-- Modal for Booking Status -->
<div id="responseModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="responseModalLabel">Booking Status</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <p id="modalMessage"></p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
       </div>
    </div>
  </div>
</div>

<!-- Cancellation Confirmation Modal -->
<div id="cancelConfirmModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="cancelConfirmModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="cancelConfirmModalLabel">Confirm Cancellation</h4>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
         </button>
       </div>
       <div class="modal-body">
         <p>Are you sure you want to cancel this session?</p>
       </div>
       <div class="modal-footer">
         <button type="button" id="confirmCancelBtn" class="btn btn-danger">Yes, Cancel</button>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Keep It</button>
       </div>
    </div>
  </div>
</div>

<!-- Include JS libraries -->
<script src="js/jquery.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/datetimepicker.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-single').select2();

    // Initialize datetimepicker
    $('#datepicker-readonly').datetimepicker({
        format: 'MMM DD, YYYY',
        ignoreReadonly: true,
        allowInputToggle: true
    });

    // When trainer is changed or date is changed, update trainer info.
    $('#trainer-name').on('change', function() {
        updateTrainerInfo();
    });
    $('#datepicker-readonly').on('dp.change', function(e) {
        updateTrainerInfo();
    });

    // Function to update trainer specialties and available timeslots.
    function updateTrainerInfo() {
        var trainerId = $('#trainer-name').val();
        var selectedDate = $('#training_date').val(); // Expected format: "MMM DD, YYYY"

        // If no trainer is selected, hide the specialties wrapper and reset timeslots.
        if (!trainerId) {
            $('#specialties-wrapper').hide().html('');
            $('#available-time-slot').html('<option value="">Select Trainer and Date First</option>');
            return;
        }
        // Always update specialties (ignoring date) and reveal the wrapper.
        $.ajax({
            url: 'personal_training_process.php',
            type: 'GET',
            data: { action: 'get_trainer_info', id: trainerId, t: new Date().getTime() },
            dataType: 'json',
            success: function(data) {
                var specialtiesHtml = '';
                if (data.specialities && data.specialities.length > 0) {
                    data.specialities.forEach(function(spec) {
                        specialtiesHtml += '<span class="label label-primary label-training-session">' + spec + '</span> ';
                    });
                } else {
                    specialtiesHtml = 'No specialties available.';
                }
                // Reveal and update the specialties wrapper.
                $('#specialties-wrapper').html('<label class="control-label col-lg-12">Trainer Specialities</label><div class="col-lg-12" id="trainer-specialities" style="margin-top: 10px;">' + specialtiesHtml + '</div>').show();
                
                // Update available timeslots only if a date is selected.
                if (selectedDate) {
                    $.ajax({
                        url: 'personal_training_process.php',
                        type: 'GET',
                        data: { action: 'get_trainer_info', id: trainerId, date: selectedDate, t: new Date().getTime() },
                        dataType: 'json',
                        success: function(data2) {
                            var timeslotHtml = '<option value="">Select Time Slot</option>';
                            if(data2.timeslots && data2.timeslots.length > 0) {
                                data2.timeslots.forEach(function(slot) {
                                    timeslotHtml += '<option value="'+slot+'">'+slot+'</option>';
                                });
                            } else {
                                timeslotHtml += '<option value="">No time slots available</option>';
                            }
                            $('#available-time-slot').html(timeslotHtml);
                        },
                        error: function() {
                            $('#available-time-slot').html('<option value="">Error loading timeslots</option>');
                        }
                    });
                } else {
                    $('#available-time-slot').html('<option value="">Select Date for timeslots</option>');
                }
            },
            error: function() {
                console.error('Error fetching trainer info.');
            }
        });
    }

    // Load upcoming sessions on page load.
    $("#upcomingSessionsContainer").load("personal_training_process.php?action=get_upcoming_sessions");

    // Submit the booking form via AJAX.
    $('#in-person-fitness-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'personal_training_process.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                $("#modalMessage").text(response.message);
                $("#responseModal").modal("show");
                if(response.status === "success") {
                    // Refresh upcoming sessions.
                    $("#upcomingSessionsContainer").load("personal_training_process.php?action=get_upcoming_sessions");
                }
            },
            error: function() {
                $("#modalMessage").text("An error occurred while processing your request.");
                $("#responseModal").modal("show");
            }
        });
    });

    // --- Cancellation via Custom Modal ---
    var currentCancelBookingId = null;
    var currentCancelButton = null;

    $(document).on('click', '.cancel-booking', function() {
        currentCancelBookingId = $(this).data("booking-id");
        currentCancelButton = $(this);
        $("#cancelConfirmModal").modal("show");
    });

    $("#confirmCancelBtn").on("click", function() {
        $.ajax({
            url: "personal_training_process.php",
            type: 'GET',
            data: { action: 'cancel_booking', booking_id: currentCancelBookingId },
            dataType: 'json',
            success: function(response) {
                $("#cancelConfirmModal").modal("hide");
                $("#modalMessage").text(response.message);
                $("#responseModal").modal("show");
                if (response.status === "success") {
                    currentCancelButton.closest("article.media").fadeOut("slow", function() {
                        $(this).remove();
                    });
                }
            },
            error: function() {
                $("#cancelConfirmModal").modal("hide");
                $("#modalMessage").text("An error occurred while processing your cancellation. Please try again later or contact support if the problem persists.");
                $("#responseModal").modal("show");
            }
        });
    });
});
</script>
</body>
</html>
