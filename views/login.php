<?php
require_once '../helper/User.php';

use Controller\UserController;

include '../model/database/DBConnect.php';
include '../model/user/UserDB.php';
include '../model/user/User.php';
include '../Controller/UserController.php';

$userController = new UserController();
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($userController->login($username, $password)) {
        // Set user ID in session
        $_SESSION['username'] = $username;
        header("Location: http://localhost/week1/views/dashboard.php");
        exit();
    } else {
        $loginError = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Login Form</title>
</head>

<body>
    <div class="login-container">
        <form action="" method="post">
            <h2>SOIOT SYSTEM</h2>

            <input type="text" id="username" name="username" required placeholder="user name">
            <input type="password" id="password" name="password" required placeholder="password">
            <?php if (isset($loginError)) echo "<div class='error-message'>Error: $loginError</div>"; ?>
            <button type="submit">Login</button>
            <div class="or text">
                or
            </div>
            <div class="btn-create text">
                create new account
            </div>
        </form>
    </div>

</body>

</html>