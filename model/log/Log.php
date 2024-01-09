<?php

namespace Model\Log;

class Log
{
    protected $id;
    protected $device_id;
    protected $name;
    protected $action;
    protected $date;

    public function __construct($date, $device_id, $name, $action, $id)
    {
        $this->date = $date;
        $this->device_id = $device_id;
        $this->name = $name;
        $this->action = $action;
        $this->id = $id;
    }

    public function getLogDate()
    {
        return $this->date;
    }

    public function getLogDeviceId()
    {
        return $this->device_id;
    }

    public function getLogName()
    {
        return $this->name;
    }

    public function getLogAction()
    {
        return $this->action;
    }

    public function getLogId()
    {
        return $this->id;
    }

    // 
    public function setLogDate($date)
    {
        $this->date = $date;
    }

    public function setLogDeviceId($device_id)
    {
        $this->device_id =  $device_id;
    }

    public function setLogName($name)
    {
        $this->name = $name;
    }

    public function setLogAction($action)
    {
        $this->action = $action;
    }

    public function setLogId($id)
    {
        $this->id = $id;
    }
}
