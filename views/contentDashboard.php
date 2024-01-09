<?php

use Controller\DeviceController;

include '../Controller/DeviceController.php';
$deviceController = new DeviceController();
$user_id = $_SESSION['user_id'];
$devices = $deviceController->getAllDevicesOfUser($user_id);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $ip = $_POST["ip"];

    $deviceController->addNewDevice($userInfo['id'], $name, $ip);
}

echo '<table>
        <thead>
            <tr>                
                <th>Devices</th>
                <th>Mac address</th>
                <th>IP</th>
                <th>Created date</th>
                <th>Power Consumption (Kw/h)</th>
            </tr>
        </thead>
        <tbody>';

// Loop through devices and create table rows
foreach ($devices as $device) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($device->getDeviceName()) . '</td>';
    echo '<td>' . htmlspecialchars($device->getDeviceMacAddress()) . '</td>';
    echo '<td>' . htmlspecialchars($device->getDeviceIp()) . '</td>';
    echo '<td>' . htmlspecialchars($device->getDeviceCreatedAt()) . '</td>';
    echo '<td>' . htmlspecialchars($device->getPowerConsumption()) . '</td>';
    echo '</tr>';
}

// HTML table footer
echo '</tbody>
      </table>';

$dataChart = null;
$labelsChart = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Device Information</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .chart_addnew {
            display: flex;
            width: 100%;
            margin: 20px 0;
        }

        input {
            width: 100%;
            /* height: 50px;
            line-height: 50px; */
            margin-bottom: 20px;
            padding: 20px 10px;
            border-radius: 7px;
            border: none;
            background-color: #f6f3f3;
            outline: none;
        }

        .chart_container {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        form {
            width: 50%;
            background-color: white;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        button {
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 7px;
            background-color: #f28e19;
            border: none;
            color: white;
            height: 40px;
            cursor: pointer;
        }

        .chart {
            background-color: white;
        }
    </style>
</head>

<body>
    <div class="chart_addnew">
        <div class="chart_container">
            <?php
            if (count($devices) > 0) {
                $dataChart = [];
                $labelsChart = [];
                $total = 0;
                foreach ($devices as $device) {
                    $total = $total + $device->getPowerConsumption();
                }
                if ($total > 0) {
                    foreach ($devices as $device) {
                        array_push($dataChart, $device->getPowerConsumption());
                        array_push($labelsChart, $device->getDeviceName());
                    }
                    echo '<div class="chart"><canvas id="myChart"></canvas></div>';
                } else {
                    echo "<div>There are no devices that use electricity</div>";
                }
            }
            ?>
        </div>
        <form action="" method="post">
            <input type="text" id="name" name="name" required placeholder="device name">
            <input type="text" id="ip" name="ip" required placeholder="ip">
            <button type="submit">ADD DEVICE</button>
        </form>
    </div>
</body>
<script>
    const ctx = document.getElementById('myChart');
    let dataChart = <?php if ($dataChart) echo  json_encode($dataChart); ?>;
    let labelsChart = <?php if ($labelsChart) echo  json_encode($labelsChart); ?>;
    if (dataChart && labelsChart) {
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: Object.values(labelsChart),
                datasets: [{
                    label: '# of total power consumption',
                    data: Object.values(dataChart),
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
</script>

</html>