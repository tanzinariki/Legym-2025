<?php
session_start();

// Ensure user is authenticated.
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not authenticated.']);
    exit;
}

require_once 'db_connect.php';

$userId = $_SESSION['user_id'];
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($action === 'filter') {
    // For upcoming sessions: show sessions on the selected Available Date.
    $classId = $_POST['classId'] ?? '';
    $availableDate = $_POST['availableDate'] ?? '';

    // Convert the date from "MMM DD, YYYY" to "YYYY-MM-DD"
    $dateObj = DateTime::createFromFormat('M d, Y', $availableDate);
    $mysqlDate = $dateObj ? $dateObj->format('Y-m-d') : date('Y-m-d');

    $query = "
        SELECT 
            t.id AS training_id,
            lc.class_name,
            t.training_date,
            t.training_time,
            t.total_seats,
            t.trainer_id,
            (SELECT COUNT(*) FROM user_training ut WHERE ut.training_id = t.id) AS reserved_count,
            (SELECT COUNT(*) FROM user_training ut WHERE ut.training_id = t.id AND ut.user_id = ?) AS user_reserved
        FROM training t
        INNER JOIN legym_class lc ON lc.id = t.class_id
        WHERE lc.id = ? 
          AND t.training_date = ?
          AND lc.status = 'Active'
        ORDER BY t.training_time ASC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iis", $userId, $classId, $mysqlDate);
    $stmt->execute();
    $result = $stmt->get_result();
    $html = '';
    if ($result->num_rows > 0) {
        while ($session = $result->fetch_assoc()) {
            $trainingId = $session['training_id'];
            $className = htmlspecialchars($session['class_name']);
            $trainingDate = $session['training_date'];
            $trainingTime = $session['training_time'];
            $totalSeats = (int)$session['total_seats'];
            $reservedCount = (int)$session['reserved_count'];
            $userReserved = (int)$session['user_reserved'];
            $spotsLeft = $totalSeats - $reservedCount;

            $dateObj = new DateTime($trainingDate);
            $displayMonth = $dateObj->format('M');
            $displayDay = $dateObj->format('d');

            if ($userReserved > 0) {
                $btnClass = 'btn-danger btn-cancel';
                $btnText = 'Cancel';
            } else {
                if ($spotsLeft > 0) {
                    $btnClass = 'btn-success btn-reserve';
                    $btnText = 'Reserve';
                } else {
                    $btnClass = 'btn-default disabled';
                    $btnText = 'Full';
                }
            }

            $html .= '
            <article class="media event">
              <a class="pull-left date">
                <p class="month">' . $displayMonth . '</p>
                <p class="day">' . $displayDay . '</p>
              </a>
              <a class="pull-right">
                <button type="button" class="btn ' . $btnClass . '" data-training-id="' . $trainingId . '">
                  ' . $btnText . '
                </button>
              </a>
              <div class="media-body">
                <span class="label label-primary">In-person</span>
                <p class="font-style-3">' . $className . '</p>
                <p class="font-style-1">Spots Left: ' . $spotsLeft . '/' . $totalSeats . '</p>
                <span>' . date('h:i A', strtotime($trainingTime)) . '</span>
              </div>
            </article>
            ';
        }
    } else {
        $html = '<p>No sessions available on the selected date.</p>';
    }
    echo $html;
    exit;
} elseif ($action === 'get_available_dates') {
    // Return available dates for the selected class.
    $classId = $_GET['classId'] ?? '';
    if (!$classId) {
        echo json_encode([]);
        exit;
    }
    $query = "SELECT DISTINCT training_date FROM training WHERE class_id = ? AND training_date >= CURDATE() ORDER BY training_date ASC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $classId);
    $stmt->execute();
    $result = $stmt->get_result();
    $dates = [];
    while ($row = $result->fetch_assoc()) {
        $dateObj = new DateTime($row['training_date']);
        $dates[] = $dateObj->format('M d, Y');
    }
    echo json_encode($dates);
    exit;
} elseif ($action === 'get_trainer_info') {
    // (Optional) If you wish to return trainer specialities for the selected session type.
    $classId = $_GET['id'] ?? '';
    // For demonstration, we return static sample data.
    echo json_encode(['specialities' => ['Group Training', 'HIIT', 'Strength']]);
    exit;
} elseif ($action === 'get_upcoming_sessions') {
    // You can implement loading all upcoming sessions here if needed.
    echo '<p>Upcoming sessions will be loaded here via AJAX.</p>';
    exit;
} elseif ($action === 'get_past_sessions') {
    // Load past reserved sessions.
    $query = "
        SELECT 
            t.id AS training_id,
            lc.class_name,
            t.training_date,
            t.training_time,
            t.total_seats,
            t.trainer_id,
            (SELECT COUNT(*) FROM user_training ut WHERE ut.training_id = t.id) AS reserved_count,
            (SELECT COUNT(*) FROM user_training ut WHERE ut.training_id = t.id AND ut.user_id = ?) AS user_reserved
        FROM training t
        INNER JOIN legym_class lc ON lc.id = t.class_id
        INNER JOIN user_training ut ON ut.training_id = t.id
        WHERE ut.user_id = ?
          AND t.training_date < CURDATE()
          AND lc.status = 'Active'
          AND lc.class_type = 'In-person'
        GROUP BY t.id
        ORDER BY t.training_date DESC
    ";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $userId, $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $html = '';
    if ($result->num_rows > 0) {
        while ($session = $result->fetch_assoc()) {
            $trainingId = $session['training_id'];
            $className = htmlspecialchars($session['class_name']);
            $trainingDate = $session['training_date'];
            $trainingTime = $session['training_time'];
            $totalSeats = (int)$session['total_seats'];
            $reservedCount = (int)$session['reserved_count'];
            $userReserved = (int)$session['user_reserved'];
            $spotsLeft = $totalSeats - $reservedCount;

            $dateObj = new DateTime($trainingDate);
            $displayMonth = $dateObj->format('M');
            $displayDay = $dateObj->format('d');

            if ($userReserved > 0) {
                $btnClass = 'btn-default disabled';
                $btnText = 'Attended';
            } else {
                $btnClass = 'btn-default disabled';
                $btnText = 'N/A';
            }

            $html .= '
            <article class="media event">
              <a class="pull-left date">
                <p class="month">' . $displayMonth . '</p>
                <p class="day">' . $displayDay . '</p>
              </a>
              <div class="media-body">
                <span class="label label-primary">Past</span>
                <p class="font-style-3">' . $className . '</p>
                <p class="font-style-1">Spots Left: ' . $spotsLeft . '/' . $totalSeats . '</p>
                <span>' . date('h:i A', strtotime($trainingTime)) . '</span>
                <br><small>Your reservation confirmed</small>
              </div>
            </article>
            ';
        }
    } else {
        $html = '<p>No past reservations found.</p>';
    }
    echo $html;
    exit;
} elseif ($action === 'reserve') {
    // Reserve a session.
    $trainingId = $_POST['trainingId'] ?? 0;
    $checkQuery = "SELECT COUNT(*) AS cnt FROM user_training WHERE user_id = ? AND training_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $trainingId);
    $stmt->execute();
    $checkResult = $stmt->get_result()->fetch_assoc();
    if ($checkResult['cnt'] > 0) {
        echo json_encode(['success' => false, 'message' => 'You have already reserved this session.']);
        exit;
    }
    $capacityQuery = "
        SELECT total_seats,
               (SELECT COUNT(*) FROM user_training WHERE training_id = ?) AS current_count
        FROM training
        WHERE id = ?
    ";
    $stmt = $conn->prepare($capacityQuery);
    $stmt->bind_param("ii", $trainingId, $trainingId);
    $stmt->execute();
    $capacityResult = $stmt->get_result()->fetch_assoc();
    if (!$capacityResult) {
        echo json_encode(['success' => false, 'message' => 'Invalid session.']);
        exit;
    }
    if ((int)$capacityResult['current_count'] >= (int)$capacityResult['total_seats']) {
        echo json_encode(['success' => false, 'message' => 'Session is already full.']);
        exit;
    }
    $insertQuery = "
        INSERT INTO user_training (training_id, user_id, booking_time, status)
        VALUES (?, ?, NOW(), 'Booked')
    ";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("ii", $trainingId, $userId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Session reserved successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to reserve session.']);
    }
    exit;
} elseif ($action === 'cancel') {
    // Cancel a reservation.
    $trainingId = $_POST['trainingId'] ?? 0;
    $checkQuery = "SELECT COUNT(*) AS cnt FROM user_training WHERE user_id = ? AND training_id = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("ii", $userId, $trainingId);
    $stmt->execute();
    $checkResult = $stmt->get_result()->fetch_assoc();
    if ($checkResult['cnt'] == 0) {
        echo json_encode(['success' => false, 'message' => 'You do not have a reservation for this session.']);
        exit;
    }
    $deleteQuery = "DELETE FROM user_training WHERE user_id = ? AND training_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("ii", $userId, $trainingId);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Reservation canceled successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to cancel reservation.']);
    }
    exit;
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}
