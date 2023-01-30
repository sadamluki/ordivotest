<?php

namespace App\Http\Abstracts;

class Yacht extends Ship
{
    protected $numOfCabins;

    public function __construct($name, $year, $speed, $capacity, $numOfCabins)
    {
        parent::__construct($name, $year, $speed, $capacity);
        $this->numOfCabins = $numOfCabins;
    }

    public function getNumOfCabins()
    {
        return $this->numOfCabins;
    }

    public function setNumOfCabins($numOfCabins)
    {
        $this->numOfCabins = $numOfCabins;
    }

    public function getType()
    {
        return 'Yacht';
    }
}
