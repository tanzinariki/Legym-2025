<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}
$fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];
require_once 'inc/header.php';
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Book Your Online Fitness Class (Reserve & Cancel)</title>
  <!-- Local CSS files -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/select2.min.css" rel="stylesheet">
  <link href="css/datetimepicker.min.css" rel="stylesheet">
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
    /* Ensure all buttons show a pointer and span full width */
    button { cursor: pointer; }
    .reserve-btn, .cancel-btn, .join-btn, .copy-link-btn {
      display: block;
      width: 100%;
      margin-top: 10px;
      text-align: center;
    }
    /* Optional styling for join button */
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
          <h3>Book Your Online Fitness Class (Reserve & Cancel)</h3>
          <h5>Select your preferred class and date to view available sessions.</h5>
        </div>
      </div>
      <div class="clearfix"></div>
      
      <!-- Filter Form -->
      <div class="row">
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <div class="x_panel">
            <div class="x_title">
              <h2>Find Your Available Online Classes</h2>
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
                      <!-- Replace with dynamic options if needed -->
                      <option value="5">Lengthen &amp; Strengthen</option>
                      <option value="6">Meditation, Breathing &amp; Movement</option>
                      <option value="7">Zumba Toning</option>
                      <option value="8">Total Body Fitness</option>
                    </select>
                  </div>
                </div>
                <!-- Date Picker -->
                <div class="form-group">
                  <label class="control-label col-lg-12" for="datepicker-readonly">
                    Choose Until When (From Today Onward) <span class="required">*</span>
                  </label>
                  <div class="col-lg-12">
                    <div class="input-group date" id="datepicker-readonly">
                      <input type="text" class="form-control" name="until_date" readonly="readonly" required />
                      <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                      </span>
                    </div>
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
      
      <!-- Online Class List Container -->
      <div class="row" id="class-list-container">
        <!-- Training tiles will be injected here -->
        <p>Please select a class and date then click Show.</p>
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

<!-- Include JS libraries (local files) -->
<script src="js/jquery.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/datetimepicker.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
// Function to copy text to clipboard using Clipboard API (with fallback)
// No alert is shown on success.
function copyTextToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).catch(function(err) {
            alert("Failed to copy link.");
        });
    } else {
        var tempInput = $("<input>");
        $("body").append(tempInput);
        tempInput.val(text).select();
        document.execCommand("copy");
        tempInput.remove();
    }
}

$(document).ready(function(){
    $('.select2-single').select2();
    
    // Initialize datetimepicker
    $('#datepicker-readonly').datetimepicker({
        format: 'MMM DD, YYYY',
        ignoreReadonly: true,
        allowInputToggle: true
    });
    
    // Debug: Log date selection
    $('input[name="until_date"]').on('dp.change', function(e){
        console.log("Date selected: " + $(this).val());
    });
    
    // Filter form submission
    $('#online-booking-form').on('submit', function(e){
        e.preventDefault();
        var onlineClass = $('#online-class').val();
        var untilDate = $('input[name="until_date"]').val();
        console.log("Form submitted with online_class:", onlineClass, "until_date:", untilDate);
        if(untilDate === ""){
            alert("Please select a valid date.");
            return;
        }
        $.ajax({
            url: 'online_booking_process.php',
            type: 'POST',
            data: {
                action: 'filter',
                online_class: onlineClass,
                until_date: untilDate
            },
            dataType: 'json',
            success: function(response){
                console.log("Filter response:", response);
                if(response.success){
                    $('#class-list-container').html(response.html);
                } else {
                    $('#class-list-container').html('<p>'+response.message+'</p>');
                }
            },
            error: function(xhr, status, error){
                console.error("Filter AJAX error:", status, error, xhr.responseText);
                alert('An error occurred while filtering classes. Please try again later.');
            }
        });
    });
    
    // Delegate click event for Reserve and Cancel buttons
    let currentCancelTrainingId = null;
    
    $(document).on('click', '.reserve-btn', function(){
        var btn = $(this);
        var trainingId = btn.data('training-id');
        console.log("Reserve clicked for trainingId:", trainingId);
        $.ajax({
            url: 'online_booking_process.php',
            type: 'POST',
            data: { action: 'reserve', training_id: trainingId },
            dataType: 'json',
            success: function(response){
                console.log("Reserve AJAX response:", response);
                if(response.success){
                    // Update the tile inline:
                    // Replace Reserve with Cancel
                    btn.removeClass('btn-success reserve-btn').addClass('btn-warning cancel-btn').text('Cancel');
                    // Append Join Session button, link text, and Copy Link button if a link is provided
                    if(response.online_training_link){
                        var joinHtml = '<button type="button" class="btn btn-primary join-btn" style="width:100%; margin-top:10px;" onclick="window.open(\'' + response.online_training_link + '\', \'_blank\');">Join Session</button>';
                        joinHtml += '<p class="link-text" style="margin-top:10px;">' + response.online_training_link + '</p>';
                        joinHtml += '<button type="button" class="btn btn-info btn-xs copy-link-btn" style="margin-top:5px;" data-link="' + response.online_training_link + '">Copy Link</button>';
                        btn.closest('.tile-stats').append(joinHtml);
                    }
                }
            },
            error: function(xhr, status, error){
                console.error("Reserve AJAX error:", status, error, xhr.responseText);
                alert('An error occurred while processing your reservation. Please try again later.');
            }
        });
    });
    
    $(document).on('click', '.cancel-btn', function(){
        var btn = $(this);
        var trainingId = btn.data('training-id');
        console.log("Cancel clicked for trainingId:", trainingId);
        currentCancelTrainingId = trainingId;
        $("#cancelConfirmModal").modal("show");
    });
    
    // Confirm cancellation
    $('#confirmCancelBtn').on('click', function(){
        if(!currentCancelTrainingId){
            return;
        }
        $.ajax({
            url: 'online_booking_process.php',
            type: 'POST',
            data: { action: 'cancel', training_id: currentCancelTrainingId },
            dataType: 'json',
            success: function(response){
                console.log("Cancel AJAX response:", response);
                $("#cancelConfirmModal").modal("hide");
                if(response.success){
                    // Revert the tile: remove join session, link, copy link; change Cancel to Reserve.
                    var tile = $('.cancel-btn[data-training-id="'+ currentCancelTrainingId +'"]').closest('.tile-stats');
                    tile.find('.join-btn, .link-text, .copy-link-btn').remove();
                    var cancelBtn = tile.find('.cancel-btn[data-training-id="'+ currentCancelTrainingId +'"]');
                    cancelBtn.removeClass('btn-warning cancel-btn').addClass('btn-success reserve-btn').text('Reserve').prop('disabled', false);
                }
                currentCancelTrainingId = null;
            },
            error: function(xhr, status, error){
                console.error("Cancel AJAX error:", status, error, xhr.responseText);
                $("#cancelConfirmModal").modal("hide");
                alert('An error occurred while processing your cancellation. Please try again later.');
            }
        });
    });
    
    // Copy link functionality
    $(document).on('click', '.copy-link-btn', function(){
        var link = $(this).data('link');
        console.log("Copy link clicked. Link:", link);
        copyTextToClipboard(link);
    });
});
</script>
</body>
</html>
