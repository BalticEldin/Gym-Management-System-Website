<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adminrf";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed."]));
}

$id = intval($_POST['id']);
$first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
$last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$username = mysqli_real_escape_string($conn, $_POST['username']);
$birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
$updated_at = date('Y-m-d H:i:s');

$sql = "UPDATE users SET 
        first_name = '$first_name', 
        last_name = '$last_name', 
        email = '$email', 
        username = '$username', 
        birthdate = '$birthdate', 
        updated_at = '$updated_at' 
        WHERE ID = $id";

if ($conn->query($sql) === TRUE) {
    echo json_encode(["status" => "success"]);
} else {
    echo json_encode(["status" => "error", "message" => $conn->error]);
}

$conn->close();
?>
