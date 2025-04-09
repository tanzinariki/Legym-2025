<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['user_id'])) {
    $fullname = $_SESSION['first_name'].' '.$_SESSION['last_name'];
} else {
    header("Location: /legym/login.php");
    exit;
}

require_once "db_connect.php";

if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database Connection Failed!"]);
    exit();
}

if (isset($_POST['agree'])) {
    $membership_plan_id = $_POST['membership_plan_id'] ?? '';
    $card_number = $_POST['card_number'] ?? '';
    $card_expire_date = $_POST['card_expire_date'] ?? '';
    $card_cvv = $_POST['card_cvv'] ?? '';

    if (empty($membership_plan_id) || empty($card_number) || empty($card_expire_date) || empty($card_cvv)) {
        echo json_encode(["status" => "error", "message" => "All fields are required!"]);
        exit();
    }

    $sql = 'SELECT * FROM user WHERE id = ?';
    $qr = $conn->prepare($sql);
    $qr->bind_param("s", $_SESSION['user_id']);
    $qr->execute();
    $res_user = $qr->get_result();
    if ($res_user->num_rows == 1) {
        $res_user = $res_user->fetch_assoc();
        if ($membership_plan_id == $res_user['membership_plan_id']) {
            echo json_encode(["status" => "sorry", "message" => "You are already enjoying the selected plan!"]);
            exit();
        }
    }

    date_default_timezone_set('America/New_York');
    $membership_start_date = date('Y-m-d');
    $membership_end_date = date('Y-m-d', strtotime('+1 year -1 day'));
    $updated_at = date('Y-m-d H:i:s');
    $status = 'Active';
    $card_number = str_replace("-", "", $card_number);
    $card_cvv = str_replace("_", "", $card_cvv);

    if (strlen($card_number) < 16) {
        echo json_encode(["status" => "error", "message" => "Card Number should be 16 digits!"]);
        exit();
    }

    if (strlen($card_expire_date) < 5) {
        echo json_encode(["status" => "error", "message" => "Card Expire Date format is not valid!"]);
        exit();
    }

    if (strlen($card_cvv) != 3 && strlen($card_cvv) != 4) {
        echo json_encode(["status" => "error", "message" => "CVV should contain 3 or 4 digits!"]);
        exit();
    }

    $sql = "UPDATE 
                user 
            SET 
                membership_plan_id = ?, 
                card_number = ?, 
                card_expire_date = ?, 
                card_cvv = ?, 
                membership_start_date = ?, 
                membership_end_date = ?, 
                status = ?, 
                updated_at = ?
            WHERE 
                id = ?";

    $qr = $conn->prepare($sql);
    $qr->bind_param(
        "sssssssss", 
        $membership_plan_id, 
        $card_number, 
        $card_expire_date, 
        $card_cvv, 
        $membership_start_date, 
        $membership_end_date, 
        $status, 
        $updated_at, 
        $_SESSION['user_id']
    );

    if ($qr->execute()) {
        $_SESSION['status'] = "Active";
        echo json_encode(["status" => "success", "message" => "Payment processed successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Payment failed!"]);
    }
    $qr->close();
    $conn->close();
    exit();
} else {
    echo json_encode(["status" => "error", "message" => "You have to agree with Terms & Cnditions"]);
    $conn->close();
    exit();
}
$conn->close();
?>
