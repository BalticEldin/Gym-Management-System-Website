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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if the username and password are provided
    if (empty($username) || empty($password)) {
        echo json_encode(array("status" => "error", "message" => "Please fill in all fields."));
        exit();
    }

    // Query to check if the username and password match (no hashing, using plain text password)
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password' LIMIT 1";
    $result = $conn->query($query);

    // Check if the login credentials are correct
    if ($result && $result->num_rows > 0) {
        // User found
        $user = $result->fetch_assoc();

        // Start a session and store the user data
        session_start();
        $_SESSION['user_id'] = $user['ID'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];

        // Return success message and redirect to index.html
        echo json_encode(array("status" => "success", "message" => "Login successful!"));
    } else {
        // Invalid credentials
        echo json_encode(array("status" => "error", "message" => "Invalid credentials"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request"));
}

// Close the database connection
$conn->close();
?>
