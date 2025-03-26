<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}

if ($_SESSION['status'] != 'Active') {
    header("Location: http://localhost/legym/user/production/dashboard.php");
    exit;
}

// Define full name
if (isset($_SESSION['first_name'], $_SESSION['last_name'])) {
    $fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
} else {
    $fullname = "Guest";
}
require_once 'inc/header.php';
require_once 'db_connect.php';

// Fetch available in-person classes (session types)
$sql = "SELECT id, class_name FROM legym_class WHERE class_type = 'In-person' AND status = 'Active'";
$result = $conn->query($sql);
$classes = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $classes[] = $row;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reserve In-Person Fitness Session</title>
  <!-- Include CSS files (Bootstrap, Select2) -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet">
  <style>
    .required { color: red; }
    .label-reserve-session { margin-right: 5px; }
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
          <h3>Reserve In-Person Fitness Session</h3>
          <h5>Reserve your spot at our in-person sessions and elevate your fitness journey.</h5>
        </div>
      </div>
      <div class="clearfix"></div>
      
      <!-- Reservation Form -->
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Find Your Upcoming Session</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <!-- The form does not use a datepicker now; it uses a dropdown for Available Date -->
              <form id="in_person_fitness_form" data-parsley-validate class="form-horizontal form-label-left">
                <!-- Session Type Dropdown -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="class-id">
                    Fitness Session <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="class-id" name="class_id" required>
                      <option value="">Select Session</option>
                      <?php foreach($classes as $class): ?>
                        <option value="<?php echo $class['id']; ?>">
                          <?php echo htmlspecialchars($class['class_name']); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- Available Date Dropdown -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="available-date">
                    Available Date <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="available-date" name="available_date" required>
                      <option value="">Select Session First</option>
                    </select>
                  </div>
                </div>
                <!-- Submit Button -->
                <div class="ln_solid"></div>
                <div class="form-group">
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-success" style="float: right;">Reserve Session</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Sessions Tabs -->
      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#upcoming">Upcoming Sessions</a></li>
        <li><a data-toggle="tab" href="#past">Past Reservations</a></li>
      </ul>
      <div class="tab-content" style="margin-top:15px;">
        <div id="upcoming" class="tab-pane fade in active">
          <div id="upcomingSessionsContainer">
            <!-- Upcoming sessions will be loaded here via AJAX -->
            <p>Please use the form above to view upcoming sessions.</p>
          </div>
        </div>
        <div id="past" class="tab-pane fade">
          <div id="pastSessionsContainer">
            <!-- Past reservations will be loaded here via AJAX -->
            <p>Your past session reservations will appear here.</p>
          </div>
        </div>
      </div>
    </div>
    <!-- /page content -->
    
    <?php require_once 'inc/copyright.php'; ?>
  </div>
</div>
<?php require_once 'inc/footer.php'; ?>

<!-- Response Modal for Reservation Status -->
<div id="responseModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
       <div class="modal-header">
         <h4 class="modal-title" id="responseModalLabel">Reservation Status</h4>
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
         <p>Are you sure you want to cancel this reservation?</p>
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
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-single').select2();

    // When session type (class) is changed, load available dates.
    $('#class-id').on('change', function() {
        var classId = $(this).val();
        if (!classId) {
            $('#available-date').html('<option value="">Select Session First</option>');
            return;
        }
        $.ajax({
            url: 'in_person_fitness_process.php',
            type: 'GET',
            data: { action: 'get_available_dates', classId: classId, t: new Date().getTime() },
            dataType: 'json',
            success: function(dates) {
                var options = '<option value="">Select Available Date</option>';
                if (dates && dates.length > 0) {
                    dates.forEach(function(date) {
                        options += '<option value="'+date+'">'+date+'</option>';
                    });
                } else {
                    options += '<option value="">No available dates</option>';
                }
                $('#available-date').html(options);
            },
            error: function() {
                console.error('Error fetching available dates.');
            }
        });
    });

    // When the reservation form is submitted, filter sessions for the selected class and available date.
    $('#in_person_fitness_form').on('submit', function(e) {
        e.preventDefault();
        var classId = $('#class-id').val();
        var availableDate = $('#available-date').val();
        if(classId === '' || availableDate === '') {
            alert('Please select both session and available date.');
            return;
        }
        $.ajax({
            url: 'in_person_fitness_process.php',
            type: 'POST',
            data: { action: 'filter', classId: classId, availableDate: availableDate },
            success: function(response) {
                $('#upcomingSessionsContainer').html(response);
            },
            error: function() {
                $('#upcomingSessionsContainer').html('<p class="text-danger">Error loading upcoming sessions.</p>');
            }
        });
    });

    // Load past reservations when the Past tab is activated.
    $('a[href="#past"]').on('shown.bs.tab', function () {
    $("#pastSessionsContainer").load("in_person_fitness_process.php?action=get_past_sessions");
});


    // Handle cancellation.
    var currentCancelId = null;
    $(document).on('click', '.btn-cancel', function(e) {
        e.preventDefault();
        currentCancelId = $(this).data('training-id');
        $('#cancelConfirmModal').modal('show');
    });
    $('#confirmCancelBtn').on('click', function() {
        $.ajax({
            url: 'in_person_fitness_process.php',
            type: 'POST',
            data: { action: 'cancel', trainingId: currentCancelId },
            dataType: 'json',
            success: function(response) {
                $('#cancelConfirmModal').modal('hide');
                $('#modalMessage').text(response.message);
                $('#responseModal').modal('show');
                if(response.success) {
                    $('#in_person_fitness_form').submit();
                    $("#pastSessionsContainer").load("in_person_fitness_process.php?action=past");
                }
            },
            error: function() {
                $('#cancelConfirmModal').modal('hide');
                $('#modalMessage').text("Error processing cancellation.");
                $('#responseModal').modal('show');
            }
        });
    });

    // Handle reservation action.
    $(document).on('click', '.btn-reserve', function(e) {
        e.preventDefault();
        var trainingId = $(this).data('training-id');
        $.ajax({
            url: 'in_person_fitness_process.php',
            type: 'POST',
            data: { action: 'reserve', trainingId: trainingId },
            dataType: 'json',
            success: function(response) {
                $('#modalMessage').text(response.message);
                $('#responseModal').modal('show');
                if(response.success) {
                    $('#in_person_fitness_form').submit();
                    $("#pastSessionsContainer").load("in_person_fitness_process.php?action=past");
                }
            },
            error: function() {
                $('#modalMessage').text("Error processing your reservation.");
                $('#responseModal').modal('show');
            }
        });
    });
});
</script>
</body>
</html>
