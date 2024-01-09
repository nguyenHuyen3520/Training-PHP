<?php

namespace Model\Device;

class Device
{
    protected $id;
    protected $user_id;
    protected $device_name;
    protected $mac_address;
    protected $ip;
    protected $power_consumption;
    protected $created_at;

    public function __construct($id = null, $user_id, $device_name, $mac_address, $ip, $power_consumption, $created_at = null)
    {
        $this->id = $id;
        $this->user_id = $user_id;
        $this->device_name = $device_name;
        $this->mac_address = $mac_address;
        $this->ip = $ip;
        $this->power_consumption = $power_consumption;
        $this->created_at = $created_at;
    }

    public function getDeviceCreatedAt()
    {
        return $this->created_at;
    }

    public function getDeviceName()
    {
        return $this->device_name;
    }

    public function getPowerConsumption()
    {
        return $this->power_consumption;
    }

    public function getAuthorId()
    {
        return $this->user_id;
    }

    public function getDeviceId()
    {
        return $this->id;
    }

    public function getDeviceMacAddress()
    {
        return $this->mac_address;
    }

    public function getDeviceIp()
    {
        return $this->ip;
    }


    //    
    public function setAuthorId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function setDeviceId($id)
    {
        $this->id = $id;
    }

    public function setDeviceMacAddress($mac_address)
    {
        $this->mac_address = $mac_address;
    }

    public function setDeviceIp($ip)
    {
        $this->ip = $ip;
    }

    public function setDeviceName($device_name)
    {
        $this->device_name = $device_name;
    }

    public function setPowerConsumption($power_consumption)
    {
        $this->power_consumption = $power_consumption;
    }

    public function setDeviceCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }
}
