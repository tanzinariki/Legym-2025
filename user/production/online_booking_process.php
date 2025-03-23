<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Please log in.']);
    exit;
}

require_once 'db_connect.php';
$db = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if ($db->connect_error) {
    echo json_encode(['success' => false, 'message' => 'DB connection failed: ' . $db->connect_error]);
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action == 'get_available_dates') {
    // Return available dates for the selected online class.
    $online_class = isset($_GET['online_class']) ? trim($_GET['online_class']) : '';
    if (!$online_class) {
        echo json_encode([]);
        exit;
    }
    $query = "SELECT DISTINCT training_date FROM training WHERE class_id = ? AND training_date >= CURDATE() ORDER BY training_date ASC";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $online_class);
    $stmt->execute();
    $result = $stmt->get_result();
    $dates = [];
    while ($row = $result->fetch_assoc()) {
        $dateObj = new DateTime($row['training_date']);
        $dates[] = $dateObj->format('M d, Y');
    }
    echo json_encode($dates);
    exit;
} elseif ($action == 'filter') {
    // Filter online sessions scheduled between today and the selected available date.
    $online_class = isset($_POST['online_class']) ? trim($_POST['online_class']) : '';
    $until_date = isset($_POST['until_date']) ? trim($_POST['until_date']) : '';
    if (empty($until_date)) {
        echo json_encode(['success' => false, 'message' => 'Please select a valid date.']);
        exit;
    }
    // Convert "MMM DD, YYYY" to "YYYY-MM-DD"
    $dateObj = DateTime::createFromFormat('M d, Y', $until_date);
    if (!$dateObj) {
        echo json_encode(['success' => false, 'message' => 'Invalid date format.']);
        exit;
    }
    $until_date_formatted = $dateObj->format('Y-m-d');
    
    // Query online sessions scheduled between today and the selected date.
    $query = "SELECT t.id AS training_id, lc.class_name, t.training_date, t.training_time,
                     t.total_seats, t.online_training_link,
                     (SELECT COUNT(*) FROM user_training ut WHERE ut.training_id = t.id) AS booked_count,
                     (SELECT COUNT(*) FROM user_training ut WHERE ut.training_id = t.id AND ut.user_id = ?) AS user_reserved
              FROM training t
              JOIN legym_class lc ON t.class_id = lc.id
              WHERE lc.class_type = 'Online'
                AND t.training_date BETWEEN CURDATE() AND ?
              ";
    if (!empty($online_class)) {
        $query .= " AND lc.id = ?";
    }
    $query .= " ORDER BY t.training_date, t.training_time";
    
    $stmt = $db->prepare($query);
    if (!empty($online_class)) {
        $stmt->bind_param("isi", $_SESSION['user_id'], $until_date_formatted, $online_class);
    } else {
        $stmt->bind_param("si", $_SESSION['user_id'], $until_date_formatted);
    }
    if (!$stmt->execute()) {
        echo json_encode(['success' => false, 'message' => 'SQL Exec Error: ' . $stmt->error]);
        exit;
    }
    $result = $stmt->get_result();
    $html = "";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $booked_count = $row['booked_count'];
            $total_seats = $row['total_seats'];
            $seats_available = $total_seats - $booked_count;
            $user_reserved = ($row['user_reserved'] > 0);
            
            $html .= '<div id="tile-' . $row['training_id'] . '" class="col-lg-3 col-md-3 col-sm-6 col-xs-12 tile-stats">';
            $html .= '  <div class="count ' . ($seats_available > 0 ? 'green-font' : 'red-font') . '">' . $seats_available . '</div>';
            $html .= '  <p class="small-card ' . ($seats_available > 0 ? 'green-font' : 'red-font') . '">Seats Available</p>';
            $html .= '  <h3>' . htmlspecialchars($row['class_name']) . '</h3>';
            $html .= '  <p>' . date("M d, Y", strtotime($row['training_date'])) . '</p>';
            $html .= '  <p style="margin-top:0;">' . date("h:i A", strtotime($row['training_time'])) . '</p>';
            
            if ($seats_available <= 0) {
                $html .= '  <button type="button" class="btn btn-danger" style="width:100%; margin-top:10px;" disabled>Booked</button>';
            } else {
                if ($user_reserved) {
                    // Show Join & Copy Link then Cancel.
                    if (!empty($row['online_training_link'])) {
                        $html .= '  <button type="button" class="btn btn-primary join-btn" style="width:100%; margin-top:10px;" '
                               . 'onclick="window.open(\'' . htmlspecialchars($row['online_training_link']) . '\', \'_blank\');">'
                               . 'Join Session</button>';
                        $html .= '  <p class="link-text" style="margin-top:10px;">' . htmlspecialchars($row['online_training_link']) . '</p>';
                        $html .= '  <button type="button" class="btn btn-info btn-xs copy-link-btn" style="margin-top:5px;" '
                               . 'data-link="' . htmlspecialchars($row['online_training_link']) . '">Copy Link</button>';
                    }
                    $html .= '  <button type="button" class="btn btn-warning cancel-btn" style="width:100%; margin-top:10px;" '
                           . 'data-training-id="' . $row['training_id'] . '">Cancel</button>';
                } else {
                    $html .= '  <button type="button" class="btn btn-success reserve-btn" style="width:100%; margin-top:10px;" '
                           . 'data-training-id="' . $row['training_id'] . '">Reserve</button>';
                }
            }
            $html .= '</div>';
        }
    } else {
        $html = "<p>No training sessions found for the selected criteria.</p>";
    }
    $stmt->close();
    echo json_encode(['success' => true, 'html' => $html]);
    exit;
} elseif ($action == 'reserve') {
    // Reserve a session.
    if (empty($_POST['training_id'])) {
        echo json_encode(['success' => false, 'message' => 'No training_id provided.']);
        exit;
    }
    $training_id = intval($_POST['training_id']);
    $user_id = intval($_SESSION['user_id']);
    
    // Check if user already reserved this session.
    $stmt = $db->prepare("SELECT id FROM user_training WHERE training_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $training_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'You have already booked this class.']);
        exit;
    }
    $stmt->close();
    
    // Check seats available.
    $stmt = $db->prepare("SELECT total_seats, online_training_link, (SELECT COUNT(*) FROM user_training WHERE training_id = ?) AS booked_count FROM training WHERE id = ?");
    $stmt->bind_param("ii", $training_id, $training_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'Training session not found.']);
        exit;
    }
    $training = $result->fetch_assoc();
    $stmt->close();
    
    $seats_available = $training['total_seats'] - $training['booked_count'];
    if ($seats_available <= 0) {
        echo json_encode(['success' => false, 'message' => 'No seats available.']);
        exit;
    }
    
    // Insert reservation.
    $stmt = $db->prepare("INSERT INTO user_training (training_id, user_id, booking_time, status) VALUES (?, ?, NOW(), 'Booked')");
    $stmt->bind_param("ii", $training_id, $user_id);
    if ($stmt->execute()) {
        echo json_encode([
            'success' => true,
            'message' => 'Class booked successfully!',
            'online_training_link' => $training['online_training_link']
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Booking failed: ' . $stmt->error]);
    }
    $stmt->close();
    exit;
} elseif ($action == 'cancel') {
    // Cancel a reservation.
    if (empty($_POST['training_id'])) {
        echo json_encode(['success' => false, 'message' => 'No training_id provided.']);
        exit;
    }
    $training_id = intval($_POST['training_id']);
    $user_id = intval($_SESSION['user_id']);
    
    // Check if booking exists.
    $stmt = $db->prepare("SELECT id FROM user_training WHERE training_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $training_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        echo json_encode(['success' => false, 'message' => 'No booking found to cancel.']);
        exit;
    }
    $stmt->close();
    
    // Delete booking.
    $stmt = $db->prepare("DELETE FROM user_training WHERE training_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $training_id, $user_id);
    if ($stmt->execute()){
        echo json_encode(['success' => true, 'message' => 'Booking canceled successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Cancellation failed: ' . $stmt->error]);
    }
    $stmt->close();
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}
$db->close();
exit;
