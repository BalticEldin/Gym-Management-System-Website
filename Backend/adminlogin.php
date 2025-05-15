<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adminrf";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array("status" => "error", "message" => "Invalid username or password.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_username = mysqli_real_escape_string($conn, $_POST['admin_username']);
    $admin_password = mysqli_real_escape_string($conn, $_POST['admin_password']);

    $sql = "SELECT * FROM admin_login_info WHERE admin_username = '$admin_username' AND admin_password = '$admin_password' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin_username;

        $response = array(
            "status" => "success",
            "message" => "Login successful.",
            "admin_username" => $admin_username
        );
    }
}

echo json_encode($response);

$conn->close();
?>
