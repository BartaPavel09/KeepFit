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
	<link rel="stylesheet" href=".\styles\start.css">
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
					<a href="\KeepFit\Discover.html" class="Discover-container">
						<p>Discover</p>
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
		<div class="options-container">
			<a href="BFC.php" style="text-decoration:none;">
				<div class="option">
					<br>
					<p>Measure your body fat</p>
					<img src="/KeepFit/images/bodyfat.png" width="50" height="50">
				</div>
			</a>
			<a href="progress.php" style="text-decoration:none;">
				<div class="option">
					<br>
					<p>Track your progress</p>
					<img src="/KeepFit/images/progress.png" width="50" height="50">
				</div>
			</a>
			<div class="option" id="recommendationBtn">
				<br>
				<p>Calculate macronutrients</p>
				<img src="/KeepFit/images/micro.png" width="50" height="50">
			</div>
		</div>
		
		<div id="recommendationModal" class="modal">
			<div class="modal-content">
				<span class="close">&times;</span>
				<p>We recommend visiting a site where you can create a good plan for macronutrients.</p>
				<div class="modal-buttons">
					<button id="yesBtn">Yes, take me there!</button>
					<button id="noBtn">No, thanks.</button>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	var dropdownContent = document.querySelector(".dropdown-content");
	function myFunction() {
		if (dropdownContent.style.display === 'none' || dropdownContent.style.display === '') {
			dropdownContent.style.display = 'block';
		} else {
			dropdownContent.style.display = 'none';
		}
	}
	var modal = document.getElementById("recommendationModal");
	var btn = document.getElementById("recommendationBtn");
	var span = document.querySelector(".close");
	var yesBtn = document.getElementById("yesBtn");
	var noBtn = document.getElementById("noBtn");

	btn.onclick = function () {
		modal.style.display = "block";
	}
	span.onclick = function () {
		modal.style.display = "none";
	}
	noBtn.onclick = function () {
		modal.style.display = "none";
	}
	yesBtn.onclick = function () {
		window.location.href = "https://www.calculator.net/macro-calculator.html";
	}
	window.onclick = function (event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
</script>

</html>