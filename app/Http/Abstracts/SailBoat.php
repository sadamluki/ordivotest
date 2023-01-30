<?php

namespace App\Http\Abstracts;

class SailBoat extends Ship
{
    protected $sailArea;

    public function __construct($name, $year, $speed, $capacity, $sailArea)
    {
        parent::__construct($name, $year, $speed, $capacity);
        $this->sailArea = $sailArea;
    }

    public function getSailArea()
    {
        return $this->sailArea;
    }

    public function setSailArea($sailArea)
    {
        $this->sailArea = $sailArea;
    }

    public function getType()
    {
        return 'Sail Boat';
    }
}
