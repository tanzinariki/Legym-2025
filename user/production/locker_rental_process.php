<?php
// Enable error reporting for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in.']);
    exit;
}

require_once 'db_connect.php';
$conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

// Handle GET requests.
if (isset($_GET['action'])) {

    // 1. Remove booking.
    if ($_GET['action'] === 'remove_booking') {
        if (empty($_GET['booking_id'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing booking ID.']);
            $conn->close();
            exit;
        }
        $booking_id = (int) $_GET['booking_id'];
        // Verify booking belongs to user and is booked.
        $verifySql = "SELECT id FROM user_locker WHERE id = ? AND user_id = ? AND status = 'Booked'";
        $stmtVerify = $conn->prepare($verifySql);
        $stmtVerify->bind_param('ii', $booking_id, $_SESSION['user_id']);
        $stmtVerify->execute();
        $stmtVerify->store_result();
        if ($stmtVerify->num_rows == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Booking not found or unauthorized.']);
            $stmtVerify->close();
            $conn->close();
            exit;
        }
        $stmtVerify->close();

        $deleteSql = "DELETE FROM user_locker WHERE id = ?";
        $stmtDelete = $conn->prepare($deleteSql);
        $stmtDelete->bind_param('i', $booking_id);
        if ($stmtDelete->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'Booking removed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error removing booking.']);
        }
        $stmtDelete->close();
        $conn->close();
        exit;
    }
    
    // 2. Get available lockers.
    if ($_GET['action'] === 'get_available_lockers') {
        if (empty($_GET['date']) || empty($_GET['time_slot'])) {
            echo json_encode(['status' => 'error', 'message' => 'Missing date or time slot.']);
            $conn->close();
            exit;
        }
        $dateInput = trim($_GET['date']);
        $dateFormatted = date("Y-m-d", strtotime($dateInput));
        $timeSlot = trim($_GET['time_slot']);
    
        $sql = "
            SELECT l.id, l.locker_name
            FROM locker l
            WHERE l.id NOT IN (
                SELECT locker_id
                FROM user_locker
                WHERE rent_date = ?
                  AND rent_duration = ?
                  AND status = 'Booked'
            )
        ";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
            $conn->close();
            exit;
        }
        $stmt->bind_param('ss', $dateFormatted, $timeSlot);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $availableLockers = [];
        while ($row = $result->fetch_assoc()) {
            $availableLockers[] = $row;
        }
    
        $stmt->close();
        $conn->close();
        echo json_encode(['status' => 'success', 'data' => $availableLockers]);
        exit;
    }
    
    // 3. Get all bookings for the logged-in user.
    if ($_GET['action'] === 'get_bookings') {
        $user_id = $_SESSION['user_id'];
        $sql = "SELECT ul.id as booking_id, ul.rent_date, ul.rent_duration, l.locker_name 
                FROM user_locker ul 
                JOIN locker l ON ul.locker_id = l.id 
                WHERE ul.user_id = ? AND ul.status = 'Booked'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $bookings = [];
        while ($row = $result->fetch_assoc()) {
            $bookings[] = $row;
        }
        $stmt->close();
        $conn->close();
        echo json_encode(['status' => 'success', 'data' => $bookings]);
        exit;
    }
}

// Handle POST: Create a new booking.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST['date']) || empty($_POST['time-slot']) || empty($_POST['locker-no'])) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        $conn->close();
        exit;
    }
    $dateInput = trim($_POST['date']);
    $dateFormatted = date("Y-m-d", strtotime($dateInput));
    $timeSlot  = trim($_POST['time-slot']);
    $locker_id = (int) $_POST['locker-no'];
    $user_id   = $_SESSION['user_id'];
    
    // Check if the locker is still available.
    $checkSql = "
        SELECT id FROM user_locker
        WHERE locker_id = ?
          AND rent_date = ?
          AND rent_duration = ?
          AND status = 'Booked'
    ";
    $stmtCheck = $conn->prepare($checkSql);
    if (!$stmtCheck) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtCheck->bind_param('iss', $locker_id, $dateFormatted, $timeSlot);
    $stmtCheck->execute();
    $stmtCheck->store_result();
    if ($stmtCheck->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Locker has just been booked. Please choose another.']);
        $stmtCheck->close();
        $conn->close();
        exit;
    }
    $stmtCheck->close();
    
    // Insert the new booking.
    $insertSql = "
        INSERT INTO user_locker (locker_id, rent_date, rent_duration, user_id, status)
        VALUES (?, ?, ?, ?, 'Booked')
    ";
    $stmtInsert = $conn->prepare($insertSql);
    if (!$stmtInsert) {
        echo json_encode(['status' => 'error', 'message' => 'Prepare failed: ' . $conn->error]);
        $conn->close();
        exit;
    }
    $stmtInsert->bind_param('issi', $locker_id, $dateFormatted, $timeSlot, $user_id);
    if ($stmtInsert->execute()) {
        $booking_id = $stmtInsert->insert_id;
        // Get the locker name.
        $sqlSelect = "SELECT id, locker_name FROM locker WHERE id = ?";
        $stmtSelect = $conn->prepare($sqlSelect);
        $stmtSelect->bind_param("i", $locker_id);
        $stmtSelect->execute();
        $resSelect = $stmtSelect->get_result();
        $locker = $resSelect->fetch_assoc();
        $stmtSelect->close();
    
        echo json_encode([
            'status' => 'success',
            'message' => 'Locker booked successfully!',
            'data' => [
                'booking_id' => $booking_id,
                'id' => $locker['id'],
                'locker_name' => $locker['locker_name']
            ],
            'date' => $dateFormatted,
            'time_slot' => $timeSlot
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Error booking locker. Please try again later.']);
    }
    $stmtInsert->close();
    $conn->close();
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
$conn->close();
exit;
