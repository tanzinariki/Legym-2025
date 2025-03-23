<?php
session_start();

// Redirect if not logged in.
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}

$fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
require_once 'inc/header.php';
require_once 'db_connect.php';

// Hard-coded online classes (or fetch from DB).
$onlineClasses = [
    ['id' => 5, 'class_name' => 'Lengthen & Strengthen'],
    ['id' => 6, 'class_name' => 'Meditation, Breathing & Movement'],
    ['id' => 7, 'class_name' => 'Zumba Toning'],
    ['id' => 8, 'class_name' => 'Total Body Fitness']
];
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reserve Your Online Fitness Class (Reserve & Cancel)</title>
  <!-- Local CSS files -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet">
  <style>
    .required { color: red; }
    .tile-stats {
      padding: 15px;
      border: 1px solid #ddd;
      margin-bottom: 15px;
      position: relative;
    }
    .green-font { color: green; }
    .red-font { color: red; }
    button { cursor: pointer; }
    .reserve-btn, .cancel-btn, .join-btn, .copy-link-btn {
      display: block;
      width: 100%;
      margin-top: 10px;
      text-align: center;
    }
    .join-btn {
      background-color: #337ab7;
      border-color: #2e6da4;
      color: #fff;
    }
  </style>
</head>
<body>
<div class="container body">
  <div class="main_container">
    <!-- Left Sidebar -->
    <div class="col-md-3 left_col">
      <div class="left_col scroll-view">
        <?php 
          require_once 'inc/top_left_nav.php';
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
          <h3>Reserve Your Online Fitness Class (Reserve & Cancel)</h3>
          <h5>Select your preferred class and available date to view sessions.</h5>
        </div>
      </div>
      <div class="clearfix"></div>
      
      <!-- Filter Form -->
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Find Your Available Online Class Sessions</h2>
              <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
              </ul>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <form id="online-booking-form" data-parsley-validate class="form-horizontal form-label-left">
                <!-- Online Class Selection -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="online-class">
                    Online Class <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="online-class" name="online_class" required>
                      <option value="">Select Online Class</option>
                      <?php foreach($onlineClasses as $cls): ?>
                        <option value="<?php echo $cls['id']; ?>"><?php echo htmlspecialchars($cls['class_name']); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <!-- Available Date Dropdown (instead of a datepicker) -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="available-date">
                    Available Date <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <select class="form-control select2-single" id="available-date" name="available_date" required>
                      <option value="">Select Online Class First</option>
                    </select>
                  </div>
                </div>
                <div class="ln_solid"></div>
                <!-- Submit Button -->
                <div class="form-group">
                  <div class="col-lg-12">
                    <button type="submit" class="btn btn-success" style="float: right;">Show</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Online Sessions Container -->
      <div class="row" id="class-list-container">
        <p>Please select a class and available date, then click Show.</p>
      </div>
    </div>
    <!-- /page content -->

    <?php require_once 'inc/copyright.php'; ?>
  </div>
</div>
<?php require_once 'inc/footer.php'; ?>

<!-- Cancel Confirmation Modal -->
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
         <p>Are you sure you want to cancel this booking?</p>
       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-danger" id="confirmCancelBtn">Yes, Cancel</button>
         <button type="button" class="btn btn-secondary" data-dismiss="modal">No, Keep It</button>
       </div>
    </div>
  </div>
</div>

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

<!-- Include JS libraries -->
<script src="js/jquery.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.select2-single').select2();

    // When online class changes, load available dates for that class.
    $('#online-class').on('change', function() {
        var onlineClass = $(this).val();
        if (!onlineClass) {
            $('#available-date').html('<option value="">Select Online Class First</option>');
            return;
        }
        $.ajax({
            url: 'online_booking_process.php',
            type: 'GET',
            data: { action: 'get_available_dates', online_class: onlineClass, t: new Date().getTime() },
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

    // When the reservation form is submitted, load sessions for the selected class and date.
    $('#online-booking-form').on('submit', function(e) {
        e.preventDefault();
        var onlineClass = $('#online-class').val();
        var availableDate = $('#available-date').val();
        if (!onlineClass || !availableDate) {
            alert('Please select both an online class and an available date.');
            return;
        }
        $.ajax({
            url: 'online_booking_process.php',
            type: 'POST',
            data: { action: 'filter', online_class: onlineClass, until_date: availableDate },
            dataType: 'json',
            success: function(response) {
                if(response.success){
                    $('#class-list-container').html(response.html);
                } else {
                    $('#class-list-container').html('<p>'+response.message+'</p>');
                }
            },
            error: function(xhr, status, error) {
                console.error("Filter AJAX error:", status, error, xhr.responseText);
            }
        });
    });
    
    // Handle reservation action.
    $(document).on('click', '.reserve-btn', function() {
        var btn = $(this);
        var trainingId = btn.data('training-id');
        $.ajax({
            url: 'online_booking_process.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'reserve', training_id: trainingId },
            success: function(response) {
                if(response.success){
                    $('#modalMessage').text(response.message);
                    $('#responseModal').modal('show');
                    $('#responseModal').on('hidden.bs.modal', function(){
                        $('#online-booking-form').submit();
                    });
                }
            }
        });
    });
    
    // Handle cancellation.
    $(document).on('click', '.cancel-btn', function() {
        var trainingId = $(this).data('training-id');
        $("#cancelConfirmModal").modal("show");
        $("#confirmCancelBtn").data('training-id', trainingId);
    });
    
    $('#confirmCancelBtn').on('click', function(){
        var trainingId = $(this).data('training-id');
        $.ajax({
            url: 'online_booking_process.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'cancel', training_id: trainingId },
            success: function(response){
                $("#cancelConfirmModal").modal("hide");
                $('#modalMessage').text(response.message);
                $('#responseModal').modal("show");
                $('#responseModal').on('hidden.bs.modal', function(){
                    $('#online-booking-form').submit();
                });
            },
            error: function(){
                $("#cancelConfirmModal").modal("hide");
                alert('Error while canceling. Please try again later.');
            }
        });
    });
    
    // Copy link functionality.
    $(document).on('click', '.copy-link-btn', function(){
        var link = $(this).data('link');
        if(navigator.clipboard){
            navigator.clipboard.writeText(link);
        } else {
            var tempInput = $("<input>");
            $("body").append(tempInput);
            tempInput.val(link).select();
            document.execCommand("copy");
            tempInput.remove();
        }
    });
});
</script>
</body>
</html>
