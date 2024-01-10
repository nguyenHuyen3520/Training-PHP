<?php

namespace Model\Log;

class LogDB
{
    protected $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function addLog($log)
    {
        $sql = "INSERT INTO logs (device_id, name, action, date) VALUES (?,?,?,?)";
        $stmt = $this->connect->prepare($sql);
        $newLog = [
            $log->getLogDeviceId(),
            $log->getLogName(),
            $log->getLogAction(),
            $log->getLogDate()
        ];
        $stmt->execute($newLog);
    }

    public function getAllLogDevices($deviceIds, $name = '')
    {
        $device_ids_str = implode(",", $deviceIds);
        $sql = "SELECT * FROM logs WHERE device_id IN ($device_ids_str) AND name LIKE '%$name%'";
        $stmt = $this->connect->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll();
        return $this->createLogFromDB($results);
    }

    public function createLogFromDB($results)
    {
        $logs = [];
        foreach ($results as $item) {
            $log = new Log($item['date'], $item['device_id'], $item['name'], $item['action'], $item['id']);
            array_push($logs, $log);
        }
        return $logs;
    }

    public function searchUserDeviceLogs($deviceIds, $name)
    {
        $device_ids_str = implode(",", $deviceIds);
        $logsQuery = "SELECT * FROM logs WHERE device_id IN ($device_ids_str) AND name LIKE '%$name%'";
        $logsResult = $this->connect->query($logsQuery);
        return $logsResult->fetchAll();
    }
}
