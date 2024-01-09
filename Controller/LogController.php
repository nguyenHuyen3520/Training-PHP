<?php

namespace Controller;

use Model\Log\Log;
use Model\Log\LogDB;
use Model\Database\DBConnect;

class LogController
{
    protected $deviceDb;
    protected $logDb;
    protected $db;
    public function __construct()
    {
        $db = new DBConnect();
        $this->logDb = new LogDB($db->connect());
    }

    public function getAllLogOfDevice($deviceIds, $keyword)
    {
        return $this->logDb->searchUserDeviceLogs($deviceIds, $keyword);
    }
}
