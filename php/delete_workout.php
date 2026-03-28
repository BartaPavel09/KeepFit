<?php
require $_SERVER['DOCUMENT_ROOT'] . '/KeepFit/php/session_manager.php';

$servername = "localhost";
$username = "Pavel";
$password = "PbonSQL";
$dbname = "keepfit";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['workoutID'])) {
    $workoutID = $_POST['workoutID'];
    $userID = $_SESSION['ID'];

    $result = $conn->query("SELECT UserID FROM workout WHERE WorkoutID = $workoutID");
    $owner = $result->fetch_assoc();

    if ($owner['UserID'] != $userID) {
        echo "You do not have permission to delete this workout.";
        exit();
    }

    $conn->begin_transaction();

    try {
        $conn->query("DELETE FROM exercise_sets WHERE ExerciseID IN (SELECT ExerciseID FROM exercise WHERE WorkoutID = $workoutID)");

        $conn->query("DELETE FROM exercise WHERE WorkoutID = $workoutID");

        $conn->query("DELETE FROM workout WHERE WorkoutID = $workoutID");

        $conn->commit();
        echo "Workout and all related records deleted successfully";
    } 
    catch (Exception $e) {
        $conn->rollback();
        echo "Error deleting records: " . $e->getMessage();
    }

    $conn->close();
    header("Location: /KeepFit/progress.php");
    exit();
}
?>
