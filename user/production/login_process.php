<?php
session_start();
require_once 'db_connect.php'; // Include your DB connection file

$response = []; // Array to store response messages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        $response["status"] = "error";
        $response["message"] = "Database connection failed!";
        echo json_encode($response);
        exit();
    }
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        $response["status"] = "error";
        $response["message"] = "All fields are required!";
        echo json_encode($response);
        exit();
    }

    $stmt = $conn->prepare("SELECT id, first_name, last_name, password, status FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION["user_email"] = $email;
            $_SESSION["status"] = $user['status'];
            $response["status"] = "success";
            $response["message"] = "Login successful!";
            $response["redirect"] = "http://localhost/legym/user/production/dashboard.php";

        } else {
            $response["status"] = "error";
            $response["message"] = "Login failed! Please try again.";
        }
        echo json_encode($response);
        exit();
    } else {
        $response["status"] = "error";
        $response["message"] = "User not found";
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
} else {
    $response["status"] = "error";
    $response["message"] = "Invalid request";
    echo json_encode($response);
    exit();
}
?>
