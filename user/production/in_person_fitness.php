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

// Query to get the In-person Training 
$sql = "SELECT 
			tr.*, 
			legon.class_name, 
			legon.class_description,
			legon.class_img,
			legon.class_type AS class_type,
			trainer.trainer_name,
			trainer.trainer_speciality,
			COUNT(ut.id) AS enrolled_seats,
			GROUP_CONCAT(ut.user_id ORDER BY ut.user_id) AS user_ids
		FROM training AS tr
		JOIN legym_class AS legon ON tr.class_id = legon.id
		JOIN trainer ON tr.trainer_id = trainer.id
		LEFT JOIN user_training AS ut ON tr.id = ut.training_id
		WHERE class_type = 'In-person'
		AND tr.training_date >= CURDATE()
		AND legon.status = 'active'
		GROUP BY tr.id";

$qr = $conn->prepare($sql);
$qr->execute();
$res_online_classes = $qr->get_result();

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Reserve In-Person Fitness Session</title>
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
					<h3>Reserve In-Person Fitness Session</h3>
					<h5>Reserve your spot at our in-person sessions and elevate your fitness journey.</h5>
				</div>
			</div>
			<div class="clearfix"></div>
			
			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_title">
							<h2>Find Your Upcoming In-person Session</h2>
							<ul class="nav navbar-right panel_toolbox">
								<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
							</ul>
							<div class="clearfix"></div>
						</div>
						<div class="x_content">
							<form id="in_person_fitness_form" data-parsley-validate class="form-horizontal form-label-left">
								<div class="form-group">
									<?php
									if ($res_online_classes->num_rows > 0) {
										while ($online_class = $res_online_classes->fetch_assoc()) {
											echo '<label for="" class="col-lg-3 col-md-4 col-sm-4 col-xs-12">';
											echo '<input type="hidden" name="" id="" value="'.$online_class['id'].'">';
											echo '<div class="x_content sample-card">';
											echo '<div class="sample-card-container">';
											echo '<div class="sample-card-limited">';
											echo '<img src="'.$online_class['class_img'].'" style="display: block; width: 100%; height: 150px;" />';
											echo '<p class="sample-card-heading">'.$online_class['class_name'].'</p>';
											echo '<p class="sample-card-sub-head">Trainer - '.$online_class['trainer_name'].'</p>';
											echo '<p class="sample-card-desc date-time">Start On: '.date('F d, Y h:i a', strtotime($online_class['training_date'].' '.$online_class['training_time'])).'</>';
											echo '<p class="" style="text-align: center;">Enrolled: '.$online_class['enrolled_seats'].'</p>';
											$user_ids = explode(",", $online_class['user_ids']);
											// if (in_array($_SESSION['user_id'], $user_ids)) {
											// 	echo '<p class="cpy-link" style="text-align: center;" data-link="'.$online_class['online_training_link'].'">link: '.$online_class['online_training_link'].'</p>';
											// }
											echo '<p class="sample-card-desc">'.$online_class['class_description'].'</p>';
											echo '</div>';
											echo '</div>';
											echo '<a href="javascript:void(0)" class="read-more">Read More</a>';
											if (in_array($_SESSION['user_id'], $user_ids)) {
												echo '<button type="button" data-training-id="'.$online_class['id'].'" class="sample-card-btn cancel-btn">Booked Already!';
												echo '<span>Cancel</span>';
											} else {
												if ($online_class['total_seats'] - $online_class['enrolled_seats'] == 0) {
													echo '<button type="button" class="sample-card-btn" style="color: red;">No Seat Available!';
												} else {
													echo '<button type="button" data-training-id="'.$online_class['id'].'" class="sample-card-btn book-btn">Available: '.$online_class['total_seats'] - $online_class['enrolled_seats'].' seats';
													echo '<span>Book</span>';
												}
											}
											echo '</button>';
											echo '</div>';
											echo '</label>';
										}
									}
									?>
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
						<p>Your upcoming session reservations will appear here.</p>
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

<!-- Javascript & JQuery -->
<script>
$(document).ready(function() {
	$('.select2-single').select2();
	$("#upcomingSessionsContainer").load("in_person_fitness_process.php?action=get_upcoming_sessions");

	// Load upcoming reservations when the Upcoming tab is activated.
	$('a[href="#upcoming"]').on('shown.bs.tab', function () {
		$("#upcomingSessionsContainer").load("in_person_fitness_process.php?action=get_upcoming_sessions");
	});

	// Load past reservations when the Past tab is activated.
	$('a[href="#past"]').on('shown.bs.tab', function () {
		$("#pastSessionsContainer").load("in_person_fitness_process.php?action=get_past_sessions");
	});

	// Book
	$(document).on('click', '.book-btn', function() {
		var btn = $(this);
		var trainingId = btn.data('training-id');
		if (typeof trainingId !== 'undefined' && trainingId !== null && trainingId !== '') {
			Swal.fire({
				title: "Are you sure?",
				text: "Click on 'Book' button to reserve a seat for you!",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Book!"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: 'in_person_fitness_process.php',
						type: 'POST',
						dataType: 'json',
						data: { action: 'reserve', trainingId: trainingId },
						success: function(response) {
							console.log(response);
							if(response.success) {
								Swal.fire({
									title: "Booked!",
									text: "Your In-person class has been booked.",
									icon: "success"
								}).then(() => {
									window.location.href = "in_person_fitness.php";
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
		var trainingId = btn.data('training-id');
		console.log(trainingId);
		if (typeof trainingId !== 'undefined' && trainingId !== null && trainingId !== '') {
			Swal.fire({
				title: "Are you sure?",
				text: "Click on \"Yes, Cancel!\" button to cancel the reservation.",
				icon: "warning",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes, Cancel!",
				cancelButtonText: "No!"
			}).then((result) => {
				if (result.isConfirmed) {
					$.ajax({
						url: 'in_person_fitness_process.php',
						type: 'POST',
						dataType: 'json',
						data: { action: 'cancel', trainingId: trainingId },
						success: function(response) {
							if(response.success) {
								Swal.fire({
									title: "Canceled!",
									text: "Your Booking for the In-person class has been canceled.",
									icon: "success"
								}).then(() => {
									window.location.href = "in_person_fitness.php";
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
});
</script>
</body>
</html>
