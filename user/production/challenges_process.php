<?php
session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: http://localhost/legym/login.php");
    exit;
}

$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action == 'join') {
    $userId = $_SESSION['user_id'];
    $challengeId = (int)$_POST['challenge_id'];

    // Check if already joined
    $checkStmt = $conn->prepare("SELECT id FROM user_challenges WHERE user_id = ? AND challenge_id = ?");
    $checkStmt->bind_param('ii', $userId, $challengeId);
    $checkStmt->execute();
    if ($checkStmt->get_result()->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => 'You\'ve already joined this challenge!']);
        // $_SESSION['error'] = "You've already joined this challenge!";
    } else {
        // Insert new participation
        $insertStmt = $conn->prepare("INSERT INTO user_challenges (user_id, challenge_id, joined_time, status) VALUES (?, ?, NOW(), 'joined')");
        $insertStmt->bind_param('ii', $userId, $challengeId);
        $insertStmt->execute();
        echo json_encode(['success' => true, 'message' => 'Successfully joined the challenge!']);
        // $_SESSION['success'] = "Successfully joined the challenge!";
    }
    // header("Location: challenges.php?challenge_id=$challengeId");
    exit;
}