<?php

use Controller\DeviceController;
use Controller\LogController;

include '../Controller/LogController.php';
include '../Controller/DeviceController.php';

$deviceController = new DeviceController();
$logController = new LogController();

$username = $_SESSION['username'];
$user_id = $_SESSION['user_id'];
$devicesResult = $deviceController->getAllDevicesOfUser($user_id);

$deviceIds = [];
foreach ($devicesResult as $device) {
    array_push($deviceIds, $device->getDeviceId());
}
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
$logsInfo = $logController->getAllLogOfDevice($deviceIds, $searchTerm);



// Pagination
$itemsPerPage = isset($_GET['show']) ? $_GET['show'] : 2;
$totalItems = count($logsInfo);
$totalPages = ceil($totalItems / $itemsPerPage);

$p_page = isset($_GET['p_page']) ? $_GET['p_page'] : 1;
$offset = ($p_page - 1) * $itemsPerPage;

// Apply pagination to devices
$searchedDevices = array_slice($logsInfo, $offset, $itemsPerPage);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $searchTerm = isset($_POST['search']) ? $_POST['search'] : '';
    $show = $_POST['number'] ? $_POST['number'] : 2;
    // Build the URL with the query parameter
    echo $_SERVER['PHP_SELF'];
    $url = "http://localhost" . $_SERVER['PHP_SELF'] . "?search=" . urlencode($searchTerm) . "&page=logs&p_page=$p_page" . "&show=" . $show;

    // Redirect to the same page with the search term in the query string
    header("Location: " . $url);
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device List</title>
    <style>
        .pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .pagination a {
            padding: 8px 16px;
            margin: 0 4px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
        }

        .pagination a.active {
            background-color: #4CAF50;
            color: white;
        }

        .header-logs {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-logs input {
            padding: 7.5px;
            width: 200px;
            margin-right: 10px;
            background-color: #eae1e1;
            border: none;
            outline: none;
        }

        .header-logs button {
            width: 100px;
            height: 31px;
            text-align: center;
            background-color: #f28e19;
            border-radius: 7px;
            border: none;
            color: #fff;
        }

        .table-logs {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header-logs">
        <h2 class="title">
            Action Logs
        </h2>
        <div style="display: flex;">
            <form method="post" action="" style="display: flex; align-items:center;">
                <div style="margin-right: 10px;">
                    show per page
                </div>
                <input type="text" name="number" value="<?php echo $itemsPerPage; ?>" placeholder="number product">
                <input type="text" name="search" id="search" value="<?php echo $searchTerm; ?>" placeholder="name">
                <button type="submit">
                    Search
                </button>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Device ID</th>
                <th>Name</th>
                <th>Action</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($searchedDevices as $device) : ?>
                <tr>
                    <td><?php echo $device['device_id']; ?></td>
                    <td><?php echo $device['name']; ?></td>
                    <td><?php echo $device['action']; ?></td>
                    <td><?php echo $device['date']; ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td class="table-logs">
                    Total
                </td>
                <td></td>
                <td></td>
                <td class="table-logs">
                    <?php echo $totalItems; ?>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <a href="?page=logs&p_page=<?php if ($searchTerm != '') {
                                            echo $i . "&search=" . $searchTerm;
                                        } else {
                                            echo $i;
                                        }  ?>" <?php echo ($i == $p_page) ? 'class="active"' : ''; ?>><?php echo $i; ?>
            </a>
        <?php endfor; ?>
    </div>

</body>

</html>