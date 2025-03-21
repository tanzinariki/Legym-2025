<?php
session_start();
header("Content-Type: application/json"); // Ensure JSON response
error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
ini_set('display_errors', 1);
require_once "db_connect.php"; // Include your database connection file

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

    if(!isset($_POST["agree"]) || empty($_POST["agree"])){        
        $response["status"] = "error";
        $response["message"] = "You must agree to terms and condition";
        echo json_encode($response);
        exit();       
    }

    if(!empty($_POST["fitness_goal"])) {
        $fitness_goal = implode (", ", $_POST["fitness_goal"]);
    } else {
        $fitness_goal = "";
    }

    // Retrieve and sanitize input data
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);
    // $fitness_goal = trim($_POST["fitness_goal"]);
    // $fitness_goal = "";
    $health_condition = trim($_POST["health_condition"]);
    

    // Basic validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $response["status"] = "error";
        $response["message"] = "All fields are required!";
        echo json_encode($response);
        exit();
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["status"] = "error";
        $response["message"] = "Invalid email format!";
        echo json_encode($response);
        exit();
    }
    if ($password !== $confirm_password) {
        $response["status"] = "error";
        $response["message"] = "Passwords do not match!";
        echo json_encode($response);
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if the email already exists
    $stmt = $conn->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $response["status"] = "error";
        $response["message"] = "Email is already registered!";
        echo json_encode($response);
        exit();
    }
    $stmt->close();

    // Insert new user into database
    $stmt = $conn->prepare("INSERT INTO user (first_name, last_name, email, password, fitness_goal, health_condition) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $first_name, $last_name, $email, $hashed_password, $fitness_goal, $health_condition);

    if ($stmt->execute()) {
        $_SESSION["user_email"] = $email;
        $response["status"] = "success";
        $response["message"] = "Signup successful!";
        $response["redirect"] = "http://localhost/legym/user/production/dashboard.php";
    } else {
        $response["status"] = "error";
        $response["message"] = "Signup failed! Please try again.";
    }

    $stmt->close();
    $conn->close();
    echo json_encode($response);
    exit();
}
?>
