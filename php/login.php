<?php
session_start();
$servername = "localhost";
$username = "Pavel";
$password = "PbonSQL";
$dbname = "keepfit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM User WHERE Email = '$email' AND Password = '$password'";

if (!empty($email) && !empty($password)) {

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo 'Login successful';
        $_SESSION['ID'] = $user['ID'];
        header('Location: /KeepFit/start.php');
        exit();
    } 
    else {
        echo "Invalid email or password.";
    }
} 
else {
    echo "Email and password are mandatory for logging in.";
}

$conn->close();