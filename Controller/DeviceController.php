<?php

namespace Controller;

use Model\Device\Device;
use Model\Device\DeviceDB;
use Model\Log\Log;
use Model\Log\LogDB;
use Model\Database\DBConnect;

class DeviceController
{
    protected $deviceDb;
    protected $logDb;
    protected $db;
    public function __construct()
    {
        $db = new DBConnect();
        $this->deviceDb = new DeviceDB($db->connect());
        $this->logDb = new LogDB($db->connect());
    }

    public function getAllDevicesOfUser($user_id)
    {
        return $this->deviceDb->getAllDevicesOfUser($user_id);
    }

    public function addNewDevice($userId, $name, $ip)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $currentTime = date("Y-m-d H:i:s");
        $getIp = file_get_contents('https://api64.ipify.org?format=json');
        $mac_address = json_decode($getIp, true);
        ob_start();
        system('ipconfig /all');
        $content = ob_get_contents();
        ob_clean();
        preg_match("/Physical Address. . . . . . . . . : (\S+)/i", $content, $matches);
        $mac = $matches[1] ?? $mac_address['ip'];
        $device = new Device(null, $userId, $name, $mac, $ip, 0, $currentTime);
        $this->deviceDb->addDevice($device);
        $lastDeviceId = $this->deviceDb->lastInsertId();

        $log = new Log($currentTime, $lastDeviceId, $name, 'Turn on', null);
        $this->logDb->addLog($log);

        header("Location: http://localhost/week1/views/dashboard.php");
    }
}
