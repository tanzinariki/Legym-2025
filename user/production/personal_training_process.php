<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}
require_once 'db_connect.php'; // Contains DB_HOST, DB_USER, DB_PASSWORD, DB_NAME
header("Content-Type: application/json");

$response = array();

// Process POST requests: Booking a training session.
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        $response["status"] = "error";
        $response["message"] = "Database connection failed!";
        echo json_encode($response);
        exit();
    }

    // Retrieve and sanitize POST data.
    $trainer_id    = isset($_POST['trainer_id']) ? trim($_POST['trainer_id']) : '';
    $training_date = isset($_POST['training_date']) ? trim($_POST['training_date']) : '';
    $timeslot      = isset($_POST['timeslot']) ? trim($_POST['timeslot']) : '';

    if (empty($trainer_id) || empty($training_date) || empty($timeslot)) {
        $response["status"] = "error";
        $response["message"] = "All fields are required!";
        echo json_encode($response);
        exit();
    }

    // Convert the training date from formatted string to "Y-m-d".
    $formatted_date = date("Y-m-d", strtotime($training_date));

    // Look for matching trainer availability.
    $stmt = $conn->prepare("SELECT id FROM trainer_availability 
                            WHERE trainer_id = ? AND date = ? AND timeslot = ?");
    $stmt->bind_param("iss", $trainer_id, $formatted_date, $timeslot);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $availability = $result->fetch_assoc();
        $trainer_availability_id = $availability['id'];
    } else {
        $response["status"] = "error";
        $response["message"] = "The selected time slot is not available for the chosen trainer.";
        echo json_encode($response);
        exit();
    }
    $stmt->close();

    // Check if the trainer is already booked for that slot (by any user)
    $stmt = $conn->prepare("SELECT id FROM user_personal_training 
                            WHERE trainer_availability_id = ? 
                              AND cancel_at IS NULL
                              AND status = 'Booked'");
    $stmt->bind_param("i", $trainer_availability_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response["status"] = "error";
        $response["message"] = "This trainer is already booked for the selected time slot.";
        echo json_encode($response);
        exit();
    }
    $stmt->close();

    // Check if the user already has a booking in the same slot (with any trainer)
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT up.id 
                            FROM user_personal_training up
                            JOIN trainer_availability ta ON up.trainer_availability_id = ta.id
                            WHERE up.user_id = ? AND ta.date = ? AND ta.timeslot = ? 
                              AND up.cancel_at IS NULL
                              AND up.status = 'Booked'");
    $stmt->bind_param("iss", $user_id, $formatted_date, $timeslot);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $response["status"] = "error";
        $response["message"] = "You have already booked a training session for this time slot.";
        echo json_encode($response);
        exit();
    }
    $stmt->close();

    // Insert the new booking record.
    $booked = 'Booked';
    $stmt = $conn->prepare("INSERT INTO user_personal_training 
                            (trainer_availability_id, user_id, booking_at, status) 
                            VALUES (?, ?, NOW(), ?)");
    $stmt->bind_param("iis", $trainer_availability_id, $user_id, $booked);
    if ($stmt->execute()) {
        $response["status"] = "success";
        $response["message"] = "Personal training session booked successfully.";
    } else {
        $response["status"] = "error";
        $response["message"] = "Booking failed. Please try again.";
    }
    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
} else {
    // Process GET requests
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        if ($conn->connect_error) {
            echo json_encode(['status' => 'error', 'message' => 'Database connection failed.']);
            exit();
        }

        if ($action == 'cancel_booking' && isset($_GET['booking_id'])) {
            // Cancellation logic.
            $booking_id = intval($_GET['booking_id']);
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT ta.date, ta.timeslot 
                    FROM user_personal_training up
                    JOIN trainer_availability ta ON up.trainer_availability_id = ta.id
                    WHERE up.id = ? AND up.user_id = ? AND up.cancel_at IS NULL";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $booking_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $update_sql = "UPDATE user_personal_training 
                               SET cancel_at = NOW(), status = 'Canceled' 
                               WHERE id = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("i", $booking_id);
                if ($update_stmt->execute()) {
                    echo json_encode(['status' => 'success', 'message' => 'Booking cancelled successfully.']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to cancel booking.']);
                }
                $update_stmt->close();
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Booking not found or already cancelled.']);
            }
            $stmt->close();

        } elseif ($action == 'get_upcoming_sessions') {
            // Return upcoming sessions.
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT up.id AS booking_id, ta.date, ta.timeslot, t.trainer_name
                    FROM user_personal_training up
                    JOIN trainer_availability ta ON up.trainer_availability_id = ta.id
                    JOIN trainer t ON ta.trainer_id = t.id
                    WHERE up.user_id = ?
                      AND ta.date >= CURDATE()
                      AND up.cancel_at IS NULL
                    ORDER BY ta.date, ta.timeslot";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $output = "";
            while ($row = $result->fetch_assoc()) {
                $formattedDate = date("F j, Y", strtotime($row['date']));
                $output .= '<article class="media event">';
                $output .= '  <a class="pull-left date">';
                $output .= '      <p class="month">' . date("M", strtotime($row['date'])) . '</p>';
                $output .= '      <p class="day">' . date("d", strtotime($row['date'])) . '</p>';
                $output .= '  </a>';
                $output .= '  <div class="media-body">';
                $output .= '      <h4 class="title">Trainer: ' . $row['trainer_name'] . '</h4>';
                $output .= '      <p class="message">Time Slot: ' . $row['timeslot'] . '</p>';
                $output .= '      <p class="message">Date: ' . $formattedDate . '</p>';
                $output .= '  </div>';
                $output .= '  <div class="pull-right">';
                $output .= '      <button type="button" class="btn btn-danger btn-sm cancel-booking" data-booking-id="' . $row['booking_id'] . '">Cancel</button>';
                $output .= '  </div>';
                $output .= '</article>';
            }
            $stmt->close();
            echo $output;

        } elseif ($action == 'get_past_sessions') {
            // Return past sessions.
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT up.id AS booking_id, ta.date, ta.timeslot, t.trainer_name, up.cancel_at
                    FROM user_personal_training up
                    JOIN trainer_availability ta ON up.trainer_availability_id = ta.id
                    JOIN trainer t ON ta.trainer_id = t.id
                    WHERE up.user_id = ?
                      AND ta.date < CURDATE()
                    ORDER BY ta.date DESC";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $result = $stmt->get_result();
            $output = "";
            while ($row = $result->fetch_assoc()) {
                $formattedDate = date("F j, Y", strtotime($row['date']));
                $status = ($row['cancel_at'] !== null) ? 'Cancelled' : 'Attended';
                $output .= '<article class="media event">';
                $output .= '  <a class="pull-left date">';
                $output .= '      <p class="month">' . date("M", strtotime($row['date'])) . '</p>';
                $output .= '      <p class="day">' . date("d", strtotime($row['date'])) . '</p>';
                $output .= '  </a>';
                $output .= '  <div class="media-body">';
                $output .= '      <h4 class="title">Trainer: ' . $row['trainer_name'] . '</h4>';
                $output .= '      <p class="message">Time Slot: ' . $row['timeslot'] . '</p>';
                $output .= '      <p class="message">Date: ' . $formattedDate . '</p>';
                $output .= '      <p class="message">Status: ' . $status . '</p>';
                $output .= '  </div>';
                $output .= '</article>';
            }
            $stmt->close();
            echo $output;

        } elseif ($action == 'get_trainer_info' && isset($_GET['id'])) {
            // Return trainer info: specialties and, if a date is provided,
            // available time slots that are not already booked.
            $trainerId = $_GET['id'];
            // 1) Get specialties.
            $stmt = $conn->prepare("SELECT trainer_speciality FROM trainer WHERE id = ?");
            $stmt->bind_param("i", $trainerId);
            $stmt->execute();
            $result = $stmt->get_result();
            $specialities = [];
            if ($row = $result->fetch_assoc()) {
                if (!empty($row['trainer_speciality'])) {
                    $specialities = array_map('trim', explode(',', $row['trainer_speciality']));
                }
            }
            $stmt->close();

            // 2) If a date is provided, return available timeslots.
            $timeslots = [];
            if (isset($_GET['date']) && !empty($_GET['date'])) {
                $inputDate = $_GET['date'];
                $formattedDate = date("Y-m-d", strtotime($inputDate));
                // Return timeslots from trainer_availability that are NOT booked.
                $stmt2 = $conn->prepare("SELECT timeslot 
                                         FROM trainer_availability 
                                         WHERE trainer_id = ? 
                                           AND date = ?
                                           AND id NOT IN (
                                               SELECT trainer_availability_id 
                                               FROM user_personal_training 
                                               WHERE cancel_at IS NULL
                                           )");
                $stmt2->bind_param("is", $trainerId, $formattedDate);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                while ($row = $result2->fetch_assoc()) {
                    $timeslots[] = $row['timeslot'];
                }
                $stmt2->close();
            }
            echo json_encode([
                'specialities' => $specialities,
                'timeslots'    => $timeslots
            ]);

        } elseif ($action == 'get_available_dates' && isset($_GET['id'])) {
            // Return distinct available future dates (formatted as "Saturday, March 23, 2025").
            $trainerId = $_GET['id'];
            $stmt = $conn->prepare("SELECT DISTINCT date 
                                    FROM trainer_availability 
                                    WHERE trainer_id = ? 
                                      AND date >= CURDATE()
                                    ORDER BY date ASC");
            $stmt->bind_param("i", $trainerId);
            $stmt->execute();
            $result = $stmt->get_result();
            $dates = [];
            while ($row = $result->fetch_assoc()) {
                $dates[] = date("l, F j, Y", strtotime($row['date']));
            }
            $stmt->close();
            echo json_encode($dates);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
        }
        $conn->close();
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit();
    }
}
?>
