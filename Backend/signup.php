<?php
// Database connection
$servername = "localhost";
$username = "root"; // default username for XAMPP
$password = ""; // default password for XAMPP
$dbname = "adminrf"; // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get data from the POST request
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);

// Set the status as '1' (active) and get the current date for created_at and updated_at
$status = 1;
$created_at = date('Y-m-d H:i:s');
$updated_at = date('Y-m-d H:i:s');

// Insert the data into the 'users' table
$sql = "INSERT INTO users (first_name, last_name, email, username, password, birthdate, status, created_at, updated_at) 
        VALUES ('$first_name', '$last_name', '$email', '$username', '$password', '$birthdate', '$status', '$created_at', '$updated_at')";

if ($conn->query($sql) === TRUE) {
    // Return success message
    echo json_encode(["status" => "success", "message" => "Registration successful. You can now log in."]);
} else {
    // Return error message
    echo json_encode(["status" => "error", "message" => "Error: " . $sql . "<br>" . $conn->error]);
}

// Close the database connection
$conn->close();
?>
