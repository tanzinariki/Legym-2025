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

$fullname = $_SESSION['first_name'] . ' ' . $_SESSION['last_name'];

require_once 'inc/header.php';
require_once 'db_connect.php';

// Query for the Trainers
$sql = "SELECT 
			tr.*, 
			IFNULL(new_tr.available_count, 0) AS available_count
		FROM 
			trainer AS tr 
		LEFT JOIN (
			SELECT
				tr.*, 
				COUNT(new_tra.trainer_id) AS available_count
			FROM trainer AS tr 
			LEFT JOIN (
				SELECT 
					tra.* 
				FROM trainer_availability AS tra
				LEFT JOIN user_personal_training AS upt ON tra.id = upt.trainer_availability_id 
				WHERE upt.user_id IS NULL
				) AS new_tra ON tr.id = new_tra.trainer_id 
			WHERE tr.status = 'Active'
			GROUP BY new_tra.trainer_id) AS new_tr ON tr.id = new_tr.id
		ORDER BY new_tr.available_count DESC";
$res = $conn->query($sql);
$trainers = [];
if ($res && $res->num_rows > 0) {
	while ($row = $res->fetch_assoc()) {
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
	<style>
		.required { color: red; }
		.label-training-session { margin-right: 5px; }
		/* Hide specialties and timeslot wrappers by default
		#specialties-wrapper, #timeslot-wrapper { display: none; } */
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
					<h3>Book Personal Training Session</h3>
					<h5>Schedule your one-on-one session with our expert trainers.</h5>
				</div>
			</div>
			<div class="clearfix"></div>
			
			<!-- Booking Form -->
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Meet Your Favorite Trainer</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content in-person-fitness">
							<form id="in-person-fitness-form" data-parsley-validate class="form-horizontal form-label-left">
								<?php foreach ($trainers as $trainer): ?>
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
								<div class="row sample-card">
									<div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">
										<img src="<?php echo $trainer['trainer_img'] ?>" style="height: 200px; width: 100%;" />
										<h2 style="margin-bottom: -5px; text-align: center; font-size: 16px;"><?php echo $trainer['trainer_name'] ?></h2>
										<?php if ($trainer['available_count'] > 0): ?>
											<button type="button" data-toggle="modal" data-target="#bookingModal" data-trainer-id="<?php echo $trainer['id'] ?>" class="sample-card-btn book-time-btn">Available
												<span>See Availability</span>
											</button>
										<?php else: ?>
											<button style="color: red;" type="button" data-trainer-id="" class="sample-card-btn">Not Available!
												<span>Not Available!</span>
											</button>
										<?php endif; ?>
									</div>
									<div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
										<div class="x_panel">
											<div class="x_title">
												<h2>Specialties</h2>
												<ul class="nav navbar-right panel_toolbox">
													<li><a class="collapse-link-2"><i class="fa fa-plus"></i></a></li>
												</ul>
												<div class="clearfix"></div>
											</div>
											<div class="x_content scroll-view-reg">
												<p style="color: #000;"><?php echo $trainer['trainer_speciality'] ?></p>
											</div>
										</div>
										<div class="x_panel">
											<div class="x_title">
												<h2>About Me</h2>
												<ul class="nav navbar-right panel_toolbox">
													<li><a class="collapse-link-2"><i class="fa fa-plus"></i></a></li>
												</ul>
												<div class="clearfix"></div>
											</div>
											<div class="x_content scroll-view-reg">
												<?php if ($trainer['trainer_cert'] != ""): ?>
													<p style="color: #000;">Certifications:</p>
													<p style="color: #000;"><?php echo $trainer['trainer_cert'] ?></p>
												<?php endif; ?>
												<?php if ($trainer['trainer_edu'] != ""): ?>
													<p style="color: #000;">Education:</p>
													<p style="color: #000;"><?php echo $trainer['trainer_edu'] ?></p>
												<?php endif; ?>
											</div>
										</div>
										<div class="x_panel">
											<div class="x_title">
												<h2>Training Philosophy</h2>
												<ul class="nav navbar-right panel_toolbox">
													<li><a class="collapse-link-2"><i class="fa fa-plus"></i></a></li>
												</ul>
												<div class="clearfix"></div>
											</div>
											<div class="x_content scroll-view-reg">
												<p style="color: #000;"><?php echo $trainer['trainer_philosophy'] ?></p>
											</div>
										</div>
									</div>
								</div>
								</div>
								<?php endforeach; ?>
								<!-- Trainer Selection -->
								<!-- <div class="form-group">
									<label class="control-label col-lg-12" for="trainer-name">
										Trainer <span class="required">*</span>
									</label>
									<div class="col-lg-12">
										<select class="form-control select2-single" id="trainer-name" name="trainer_id" required>
											<option value="">Select Trainer</option>
											<?php // foreach($trainers as $trainer): ?>
												<option value="<?php // echo $trainer['id']; ?>">
													<?php // echo $trainer['trainer_name']; ?>
												</option>
											<?php // endforeach; ?>
										</select>
									</div>
								</div> -->

								<!-- Trainer Specialties Wrapper (hidden by default) -->
								<!-- <div class="form-group" id="specialties-wrapper">
									<label class="control-label col-lg-12">Trainer Specialties</label>
									<div class="col-lg-12" id="trainer-specialities" style="margin-top: 10px;">
									</div>
								</div> -->

								<!-- Available Dates -->
								<!-- <div class="form-group">
									<label class="control-label col-lg-12" for="available-dates">
										Available Dates <span class="required">*</span>
									</label>
									<div class="col-lg-12">
										<select class="form-control select2-single" id="available-dates" name="training_date" required>
											<option value="">Select Trainer First</option>
										</select>
									</div>
								</div> -->

								<!-- Available Time Slots (hidden by default) -->
								<!-- <div class="form-group" id="timeslot-wrapper">
									<label class="control-label col-lg-12" for="available-time-slot">
										Available Time Slots <span class="required">*</span>
									</label>
									<div class="col-lg-12">
										<select class="form-control select2-single" id="available-time-slot" name="timeslot" required>
											<option value="">Select Date First</option>
										</select>
									</div>
								</div> -->

								<!-- <div class="ln_solid"></div> -->
								<!-- Submit Button -->
								<!-- <div class="form-group">
									<div class="col-lg-12">
										<button type="submit" class="btn btn-success" style="float: right;">Book The Trainer</button>
									</div>
								</div> -->
							</form>
						</div>
					</div>
				</div>
			</div>

			<!-- Sessions Tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a data-toggle="tab" href="#upcoming">Upcoming Sessions</a></li>
				<li><a data-toggle="tab" href="#past">Past Sessions</a></li>
			</ul>
			<div class="tab-content" style="margin-top:15px;">
				<div id="upcoming" class="tab-pane fade in active">
					<div id="upcomingSessionsContainer">
						<!-- Upcoming sessions loaded via AJAX -->
					</div>
				</div>
				<div id="past" class="tab-pane fade">
					<div id="pastSessionsContainer">
						<!-- Past sessions loaded via AJAX -->
					</div>
				</div>
			</div>
		</div>
		<!-- /page content -->

		<?php require_once 'inc/copyright.php'; ?>
	</div>
</div>
<?php require_once 'inc/footer.php'; ?>

<!-- Modal for Booking -->
<div id="bookingModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bookingModalLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" style="display: inline;" id="bookingModalLabel">Available Schedule</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin: 3px 0 0;">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<!-- JavaScripts & JQuery -->
<script>
$(document).ready(function() {
	$('.in-person-fitness .sample-card').each(function () {
		$(this).find('.x_content').hide().first().show();
	});

	$('.in-person-fitness .sample-card div.x_panel:first-child').css('height', 'auto');
	$('.in-person-fitness .sample-card div.x_panel:first-child').find('i').toggleClass('fa-plus fa-minus');
	
	$('.select2-single').select2();

	// Show Available Schedule
	$(document).on('click', '.book-time-btn', function() {
		var btn = $(this);
		var trainer_id = btn.data('trainer-id');
		if (typeof trainer_id !== 'undefined' && trainer_id !== null && trainer_id !== '') {
			$.ajax({
				url: 'personal_training_process.php',
				type: 'POST',
				dataType: 'json',
				data: { action: 'book-time', trainer_id: trainer_id },
				success: function(response) {
					console.log(response);
					if(response.success) {
						$('.modal-body').html(response);
					} else {
						$('.modal-body').html(response);
					}
				},
				error: function(response) {
					$('.modal-body').html(response);
				}
			});
		}
	});

	// Book
	$(document).on('click', '.book-btn', function() {
		var btn = $(this);
		var training_id = btn.data('training-id');
		if (typeof training_id !== 'undefined' && training_id !== null && training_id !== '') {
			Swal.fire({
				title: "Are you sure?",
				text: "Click on 'Book' button to book this schedule!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Book!"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: 'personal_training_process.php',
						type: 'POST',
						dataType: 'json',
						data: { action: 'reserve', training_id: training_id },
						success: function(response) {
							console.log(response);
							if(response.status) {
								Swal.fire({
									title: "Booked!",
									text: "Your schedule has been booked.",
									icon: "success"
								}).then(() => {
									// $('#bookingModal').modal('hide');
									window.location.href = "personal_training.php";
								});
							}
						}
					});
				}
			});
		} else {
			Swal.fire({
				title: "Error!",
				text: response.message,
				icon: "error",
				confirmButtonText: "OK"
			});
		}
	});

	// Cancel
	$(document).on('click', '.cancel-btn', function() {
		var btn = $(this);
		var booking_id = btn.data('booking-id');
		console.log(booking_id);
		if (typeof booking_id !== 'undefined' && booking_id !== null && booking_id !== '') {
			Swal.fire({
				title: "Are you sure?",
				text: "Click on \"Yes, Cancel!\" button to cancel the booking.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, Cancel!",
				cancelButtonText: "No!"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: 'personal_training_process.php',
						type: 'POST',
						dataType: 'json',
						data: { action: 'cancel', booking_id: booking_id },
						success: function(response) {
							if(response.status) {
								Swal.fire({
									title: "Canceled!",
									text: "Your Booking has been canceled.",
									icon: "success"
								}).then(() => {
									window.location.href = "personal_training.php";
								});
							}
						}
					});
				}
			});
		} else {
			Swal.fire({
				title: "Error!",
				text: response.message,
				icon: "error",
				confirmButtonText: "OK"
			});
		}
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
				$("#modalMessage").text("An error occurred while processing your cancellation.");
				$("#responseModal").modal("show");
			}
		});
	});

		// When available date selection changes, load available time slots.
		$('#available-dates').on('change', function() {
				var selectedDate = $(this).val();
				if (!selectedDate) {
						$('#timeslot-wrapper').hide();
						$('#available-time-slot').html('<option value="">Select Date First</option>');
				} else {
						$('#timeslot-wrapper').show();
						updateAvailableTimeSlots();
				}
		});

		// Function to update trainer specialties and available dates.
		function updateTrainerInfo() {
				var trainerId = $('#trainer-name').val();
				if (!trainerId) {
						$('#specialties-wrapper').hide().html('');
						$('#available-dates').html('<option value="">Select Trainer First</option>');
						$('#timeslot-wrapper').hide();
						$('#available-time-slot').html('<option value="">Select Date First</option>');
						return;
				}

				// 1) Fetch trainer specialties.
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
								$('#specialties-wrapper').html(
									'<label class="control-label col-lg-12">Trainer Specialties</label>' +
									'<div class="col-lg-12" id="trainer-specialities" style="margin-top: 10px;">' + specialtiesHtml + '</div>'
								).show();

								// 2) Fetch available dates for the trainer.
								$.ajax({
										url: 'personal_training_process.php',
										type: 'GET',
										data: { action: 'get_available_dates', id: trainerId, t: new Date().getTime() },
										dataType: 'json',
										success: function(dates) {
												var options = '<option value="">Select Date</option>';
												if (dates && dates.length > 0) {
														dates.forEach(function(date) {
																options += '<option value="'+date+'">'+date+'</option>';
														});
												} else {
														options += '<option value="">No available dates</option>';
												}
												$('#available-dates').html(options);
												$('#timeslot-wrapper').hide();
												$('#available-time-slot').html('<option value="">Select Date First</option>');
										},
										error: function() {
												console.error('Error fetching available dates.');
										}
								});
						},
						error: function() {
								console.error('Error fetching trainer info.');
						}
				});
		}

		// Function to update available time slots.
		// This call now queries the back end to return only those timeslots that are not booked.
		function updateAvailableTimeSlots() {
				var trainerId = $('#trainer-name').val();
				var selectedDate = $('#available-dates').val();
				if (!trainerId || !selectedDate) {
						$('#timeslot-wrapper').hide();
						$('#available-time-slot').html('<option value="">Select Trainer and Date First</option>');
						return;
				}
				$.ajax({
						url: 'personal_training_process.php',
						type: 'GET',
						data: { action: 'get_trainer_info', id: trainerId, date: selectedDate, t: new Date().getTime() },
						dataType: 'json',
						success: function(data) {
								var timeslotHtml = '<option value="">Select Time Slot</option>';
								if (data.timeslots && data.timeslots.length > 0) {
										data.timeslots.forEach(function(slot) {
												timeslotHtml += '<option value="'+slot+'">'+slot+'</option>';
										});
								} else {
										timeslotHtml += '<option value="">No time slots available</option>';
								}
								$('#available-time-slot').html(timeslotHtml);
						},
						error: function() {
								$('#available-time-slot').html('<option value="">Error loading time slots</option>');
						}
				});
		}

		// Load upcoming sessions on page load.
		$("#upcomingSessionsContainer").load("personal_training_process.php?action=get_upcoming_sessions");

		// Load past sessions when the Past tab is activated.
		$('a[href="#past"]').on('shown.bs.tab', function () {
				$("#pastSessionsContainer").load("personal_training_process.php?action=get_past_sessions");
		});

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
								$("#bookingModal").modal("show");
								if(response.status === "success") {
										$("#upcomingSessionsContainer").load("personal_training_process.php?action=get_upcoming_sessions");
								}
						},
						error: function() {
								$("#modalMessage").text("An error occurred while processing your request.");
								$("#bookingModal").modal("show");
						}
				});
		});

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
										$("#upcomingSessionsContainer").load("personal_training_process.php?action=get_upcoming_sessions");
								}
						},
						error: function() {
								$("#modalMessage").text("An error occurred while processing your request.");
								$("#responseModal").modal("show");
						}
				});
		});

		// Cancel booking via confirmation modal.
		var currentCancelBookingId = null;
		var currentCancelButton = null;
		$(document).on('click', '.cancel-booking', function() {
				currentCancelBookingId = $(this).data("booking-id");
				currentCancelButton = $(this);
				$("#cancelConfirmModal").modal("show");
		});
});
</script>
</body>
</html>
