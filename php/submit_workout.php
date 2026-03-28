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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['exerciseName'])) {
    $workoutName = $_POST['workoutName'];
    $userID = $_SESSION['ID'];
    $restTime = $_POST['restTime'];

    $sql = "INSERT INTO workout (WorkoutName, UserID, RestTime) VALUES ('$workoutName', '$userID', '$restTime')";
    $conn->query($sql);
    $workoutID = $conn->insert_id;

    foreach ($_POST['exerciseName'] as $i => $exerciseName) {
        $sql = "INSERT INTO exercise (ExerciseName, WorkoutID) VALUES ('$exerciseName', '$workoutID')";
        $conn->query($sql);
        $exerciseID = $conn->insert_id;

        foreach ($_POST['reps'][$i] as $reps) {
            $sql = "INSERT INTO exercise_sets (ExerciseID, Reps) VALUES ('$exerciseID', '$reps')";
            $conn->query($sql);
        }
    }

    $conn->close();
    header("Location: /KeepFit/progress.php");
    exit();
}
?>
