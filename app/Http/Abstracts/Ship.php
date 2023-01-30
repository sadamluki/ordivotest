<?php

namespace App\Http\Abstracts;

abstract class Ship
{
    protected $name;
    protected $year;
    protected $speed;
    protected $capacity;

    public function __construct($name, $year, $speed, $capacity)
    {
        $this->name = $name;
        $this->year = $year;
        $this->speed = $speed;
        $this->capacity = $capacity;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getSpeed()
    {
        return $this->speed;
    }

    public function setSpeed($speed)
    {
        $this->speed = $speed;
    }

    public function getCapacity()
    {
        return $this->capacity;
    }

    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    abstract public function getType();
}
