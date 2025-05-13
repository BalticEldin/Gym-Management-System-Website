<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adminrf";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array("status" => "error", "message" => "Invalid username or password.");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the username and password from the form
    $admin_username = $_POST['admin_username'];
    $admin_password = $_POST['admin_password'];

    // Prevent SQL injection
    $admin_username = mysqli_real_escape_string($conn, $admin_username);
    $admin_password = mysqli_real_escape_string($conn, $admin_password);

    // Check if username and password match in the database
    $sql = "SELECT * FROM admin_login_info WHERE admin_username = '$admin_username' AND admin_password = '$admin_password' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // If credentials are correct
        $response = array("status" => "success", "message" => "Login successful.");
    } else {
        // If credentials are incorrect
        $response = array("status" => "error", "message" => "Invalid username or password.");
    }
}

// Return JSON response
echo json_encode($response);

$conn->close();
?>
