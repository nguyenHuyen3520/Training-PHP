<?php

namespace Model\Device;

use Exception;

class DeviceDB
{
    protected $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function addDevice($device)
    {
        if ($this->connect === null) {
            throw new Exception("Database connection is not established.");
        }
        $sql = "INSERT INTO devices (user_id, device_name, mac_address, ip, power_consumption) VALUES (?,?,?,?,?)";
        $stmt = $this->connect->prepare($sql);
        $newDevice = [
            $device->getAuthorId(),
            $device->getDeviceName(),
            $device->getDeviceMacAddress(),
            $device->getDeviceIp(),
            0
        ];
        $stmt->execute($newDevice);
    }

    public function lastInsertId()
    {
        return $this->connect->lastInsertId();
    }

    public function getAllDevicesOfUser($user_id)
    {
        $sql = "SELECT * FROM devices WHERE user_id = $user_id ";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $this->createDevicesFromDB($results);
    }

    public function createDevicesFromDB($results)
    {
        $devices = [];
        foreach ($results as $item) {
            $device = new Device($item['id'], $item['user_id'], $item['device_name'], $item['mac_address'], $item['ip'], $item['power_consumption'], $item['created_at']);
            array_push($devices, $device);
        }
        return $devices;
    }
}
