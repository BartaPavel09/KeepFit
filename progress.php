<?php include '.\php\session_manager.php';

if (!isset($_SESSION['ID'])) {
    header('Location: index.html');
    exit();
}

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>KeepFit</title>
    <link rel="icon" type="image/x-icon" href="\images\keepfit-favicon-color.png">
    <link rel="stylesheet" href=".\styles\progress.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href=".\images\keepfit-favicon-color.png">

</head>

<body>
    <div class="content-container">
        <div class="Meniu">
            <div id="imgdis">
                <div style="display:flex; align-items:center;" class="logo-container">
                    <a href="index.html"><img src=".\images\logo simplu\png\logo-no-background.png" alt="Logo"
                            class="img_logo_meniu"></a>
                </div>
                <div>
                    <a href="\KeepFit\start.php" class="home-container">
                        <p>Home</p>
                    </a>
                </div>
            </div>
            <div class="log-out">
                <button1 onclick="myFunction()" class="dropbtn"><img id="myImage" src=".\images\sageata.png"
                        alt="sageata" class="sageata"></button1>
                <div class="dropdown-content" style="display:none;">
                    <a href="?logout=true">Log out</a>
                </div>
            </div>
        </div>
        <div class="progress-container">
            <h1>Your Progress Tracker</h1>
            <section-left>
                <p class="guide-text">Add your workouts and track your progress below:</p>

                <button id="showFormButton" class="buttonShow">Add Workout</button>
                <div id="workoutForm" style="display:none;">
                    <form action=".\php\submit_workout.php" method="POST">
                        <p2>Workout Name:</p2><input type="text" name="workoutName" required><br>
                        <div id="exercisesContainer">

                        </div>
                        <button id="addExerciseButton" type="button">Add Exercise</button><br>
                        <p2>Rest Time:</p2><input type="number" name="restTime" placeholder="30 seconds" min="0"
                            required><br>
                        <button type="submit" name="Send">Send</button>
                    </form>
                </div>

                <button id="showDeleteForm" class="buttonShow">Delete Workout</button>
                <div id="deleteWorkoutForm" style="display:none;">
                    <form action="./php/delete_workout.php" method="POST">
                        <input type="number" name="workoutID" placeholder="Enter Workout ID" required>
                        <button type="submit">Delete Workout</button>
                    </form>
                </div>
            </section-left>

            <section-right>
                <p class="guide-text">Your Workout History:</p>
                <form action="progress.php" method="GET">
                    <button id="showWorkouts" type="submit" name="showWorkouts" value="true">Show
                        Workouts</button>
                    <button id="hide">Hide Workouts</button>
                </form>
                <div id="workoutsContainer">
                    <?php
                    $servername = "localhost";
                    $username = "Pavel";
                    $password = "PbonSQL";
                    $dbname = "keepfit";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                    }

                    if (isset($_GET['showWorkouts']) && $_GET['showWorkouts'] == 'true') {
                        $userID = $_SESSION['ID'];
                    
                        $query = "SELECT w.WorkoutID, w.WorkoutName, w.WorkoutDate, w.RestTime, e.ExerciseName, es.Reps
                                  FROM workout w
                                  JOIN exercise e ON w.WorkoutID = e.WorkoutID
                                  JOIN exercise_sets es ON e.ExerciseID = es.ExerciseID
                                  WHERE w.UserID = $userID
                                  ORDER BY w.WorkoutDate DESC, e.ExerciseID, es.SetID";

                        $result = $conn->query($query);

                        $currentWorkout = null;
                        $currentExercise = null;
                        $setCounter = 1;
                        echo "<div class='workouts-list'>";
                        while ($row = $result->fetch_assoc()) {
                            if ($currentWorkout !== $row['WorkoutID']) {
                                if ($currentWorkout !== null) {
                                    echo "<hr>";
                                    echo "</ul>";
                                }
                                echo "<h3>ID: " . htmlspecialchars($row['WorkoutID']) . " - " . htmlspecialchars($row['WorkoutName']) . " - " . htmlspecialchars($row['WorkoutDate']) . "</h3>";
                                echo "<p3>Rest Time: " . htmlspecialchars($row['RestTime']) . " seconds</p3>";
                                echo "<ul>";
                                $currentWorkout = $row['WorkoutID'];
                                $currentExercise = null;
                            }

                            if ($currentExercise !== $row['ExerciseName']) {
                                $currentExercise = $row['ExerciseName'];
                                echo "<hr>";
                                echo "<h2> Exercise: " . htmlspecialchars($row['ExerciseName']) . "</h2>";
                                $setCounter = 1;
                            }
                            echo "<li><p>" . "Set " . $setCounter . ": Reps: " . htmlspecialchars($row['Reps']) . "</p></li>";
                            $setCounter++;
                        }
                        if ($currentWorkout !== null) {
                            echo "<hr>";
                            echo "</ul>";
                        }
                        echo "</div>";
                    }
                    $conn->close();
                    ?>
                </div>
            </section-right>
        </div>
    </div>
</body>
<script>
    function myFunction() {
        var dropdownContent = document.querySelector('.dropdown-content');
        if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
            dropdownContent.style.display = 'block';
        } else {
            dropdownContent.style.display = 'none';
        }
    }
    document.addEventListener('DOMContentLoaded', function () {
        var addExerciseButton = document.getElementById("addExerciseButton");
        var exercisesContainer = document.getElementById("exercisesContainer");
        var showFormButton = document.getElementById("showFormButton");
        var workoutForm = document.getElementById("workoutForm");
        var hideworkouts = document.getElementById('hide');
        var showDeleteFormButton = document.getElementById('showDeleteForm');
        var deleteForm = document.getElementById('deleteWorkoutForm');

        showDeleteFormButton.addEventListener('click', function () {
            if (deleteForm.style.display === 'none' || deleteForm.style.display === '') {
                deleteForm.style.display = 'block';
                showDeleteFormButton.textContent = 'Hide Delete Form';
            } else {
                deleteForm.style.display = 'none';
                showDeleteFormButton.textContent = 'Delete Workout';
            }
        });

        hideworkouts.onclick = function () {
            document.getElementById('workoutsContainer').style.display = 'none';
        }

        showFormButton.addEventListener('click', function () {
            if (workoutForm.style.display === 'none' || workoutForm.style.display === '') {
                workoutForm.style.display = 'flex';
                showFormButton.textContent = 'Hide Workout Form';
            } else {
                workoutForm.style.display = 'none';
                showFormButton.textContent = 'Add Workout';
            }
        });

        addExerciseButton.addEventListener('click', function () {
            var exerciseIndex = document.querySelectorAll('.exercise').length;

            var exerciseDiv = document.createElement("div");
            exerciseDiv.classList.add("exercise");

            exerciseDiv.innerHTML =
                '<input type="text" name="exerciseName[' + exerciseIndex + ']" placeholder="Exercise name" required><br>' +
                '<div class="setsContainer">' +
                '<input type="number" class="numSets" placeholder="Sets number" min="1" required><br>' +
                '<button type="button" class="addSetButton">Add Sets</button>' +
                '</div>' +
                '<button type="button" class="removeExerciseBtn">Delete Exercise</button>' +
                '<hr>';

            exercisesContainer.appendChild(exerciseDiv);

            exerciseDiv.querySelector('.addSetButton').addEventListener('click', function () {
                addSet(exerciseDiv);
            });
            
            exerciseDiv.querySelector('.removeExerciseBtn').addEventListener('click', function () {
                exerciseDiv.remove();
            });
        });
        
        function addSet(exerciseDiv) {
            var setContainer = exerciseDiv.querySelector('.setsContainer');
            var exerciseIndex = Array.from(document.querySelectorAll('.exercise')).indexOf(exerciseDiv);
            var numberOfSets = parseInt(setContainer.querySelector('.numSets').value) || 0;

            for (var i = 0; i < numberOfSets; i++) {
                var newSetHTML =
                    '<div class="set">' +
                    'Set ' + (i + 1) + ': <input type="number" name="reps[' + exerciseIndex + '][]" placeholder="No. Reps" value="10" min="1"><br>' +
                    '</div>';
                setContainer.insertAdjacentHTML('beforeend', newSetHTML);
            }
        }
    });
</script>

</html>