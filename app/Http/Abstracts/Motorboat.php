<?php

namespace App\Http\Abstracts;

class MotorBoat extends Ship
{
    protected $enginePower;

    public function __construct($name, $year, $speed, $capacity, $enginePower)
    {
        parent::__construct($name, $year, $speed, $capacity);
        $this->enginePower = $enginePower;
    }

    public function getEnginePower()
    {
        return $this->enginePower;
    }

    public function setEnginePower($enginePower)
    {
        $this->enginePower = $enginePower;
    }

    public function getType()
    {
        return 'Motor Boat';
    }
}
