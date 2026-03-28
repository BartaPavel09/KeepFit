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

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

$registration_successful = 0;

$sql = "INSERT INTO User (Username, Email, Password) VALUES ('$username', '$email', '$password')";

if (!empty($_POST['username']) && !empty($_POST['email']) && !empty($_POST['password'])) {
    if ($conn->query($sql) === TRUE) {
        echo 'Registration successful';
        $registration_successful = 1;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    if ($registration_successful) {
        $sql = "SELECT ID FROM User WHERE Username = '$username'";
        $result = $conn->query($sql);
        if ($row = $result->fetch_assoc()) {
            $_SESSION['ID'] = $row['ID'];
            header('Location: /KeepFit/start.php');
            exit();
        }
        else {
            echo 'User has not been found';
        }
    }
} else {
    echo "All fields must be completed.";
}

$conn->close();
?>
