<?php include '.\php\session_manager.php';
if (isset($_SESSION['ID'])) {
    header('Location: start.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Log In</title>
    <link rel="icon" type="image/x-icon" href=".\images\keepfit-favicon-color.png">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href=".\styles\login.css">
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
                <div class="Register-container">
                    <a href=".\Register.html" style="text-decoration: none;" class="Register">
                        <p>Register</p>
                    </a>
                </div>
            </div>
            <div class="login_container">
                <div class="Meniu_login">
                    <form action=".\php\login.php" method="POST">
                        <input type="text" id="email" name="email" placeholder="Email" required>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <button type="submit">Log In</button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>