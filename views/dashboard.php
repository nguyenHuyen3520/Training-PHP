<?php

use Controller\UserController;

include '../model/database/DBConnect.php';
include '../model/user/UserDB.php';
include '../model/user/User.php';
include '../model/device/DeviceDB.php';
include '../model/device/Device.php';
include '../model/log/LogDB.php';
include '../model/log/Log.php';
include '../Controller/UserController.php';

session_start();
$username = $_SESSION['username'];
// Kiểm tra xem người dùng đã đăng nhập chưa
if (!isset($_SESSION['username'])) {
    header("Location: http://localhost/week1/views/login.php");
    exit();
}

$userController = new UserController();

$userInfo = $userController->getUserInfoWithUsername($username);
$_SESSION['user_id'] = $userInfo['id'];
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="dashboard.css">
    <title>Dashboard</title>
</head>

<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="sidebar-item">Device Management
                <ul>
                    <li <?php echo ($page === 'dashboard') ? 'class="active"' : ''; ?>>
                        <a href="dashboard.php?page=dashboard">Dashboard</a>
                    </li>
                    <li <?php echo ($page === 'logs') ? 'class="active"' : ''; ?>>
                        <a href="dashboard.php?page=logs">Logs</a>
                    </li>
                    <li <?php echo ($page === 'settings') ? 'class="active"' : ''; ?>>
                        <a href="dashboard.php?page=settings">Settings</a>
                    </li>
                </ul>
                </ul>
            </div>
        </div>
        <div class="dashboard-right">
            <?php
            echo "<div class='header'>";
            echo "<div class='user-info'>";
            echo "<span class='username'>$username</span>";
            echo "<i class='fas fa-user-circle' style='font-size:24px'></i>";
            echo "</div>";
            echo "</div>";
            ?>
            <?php
            if (!empty($page)) {
                echo "<div class='content'>";
                switch ($page) {
                    case 'dashboard':
                        include __DIR__ . "/contentDashboard.php";
                        break;
                    case 'logs':
                        include __DIR__ . "/contentLogs.php";
                        break;
                    case 'settings':
                        echo "Settings Content";
                        break;
                    default:
                        echo "Default Content";
                }
                echo "</div>";
            }
            ?>
        </div>
    </div>

</body>

</html>