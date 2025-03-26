<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: application/json");

require_once 'user/production/db_connect.php';

$response = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["status"] = "error";
        $response["message"] = "Please enter a valid email address.";
        echo json_encode($response);
        exit;
    }

    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        $response["status"] = "error";
        $response["message"] = "Database connection failed.";
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $response["status"] = "error";
        $response["message"] = "No user found with this email.";
        echo json_encode($response);
        exit;
    }

    $stmt->bind_result($user_id);
    $stmt->fetch();
    $stmt->close();

    // Generate temporary password
    $temp_password = bin2hex(random_bytes(4));
    $hashed_temp_password = password_hash($temp_password, PASSWORD_BCRYPT);

    $update = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
    $update->bind_param("si", $hashed_temp_password, $user_id);

    if ($update->execute()) {
        // Send email
        $subject = "Le Gym Temporary Password";
        $message = "Hi,\n\nYour temporary password is: $temp_password\n\nPlease use it to reset your password.\n\nLe Gym Team";
        $headers = "From: no-reply@legym.com\r\n";

        if (mail($email, $subject, $message, $headers)) {
            $response["status"] = "success";
            $response["message"] = "Temporary password sent. Please check your email.";
            $response["redirect"] = "http://localhost/legym/reset_password.php";
        } else {
            $response["status"] = "error";
            $response["message"] = "Failed to send email.";
        }
    } else {
        $response["status"] = "error";
        $response["message"] = "Could not update password.";
    }

    $update->close();
    $conn->close();
    echo json_encode($response);
    exit;
}
?>
