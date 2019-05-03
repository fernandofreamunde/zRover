<?php


namespace App\Entity;


class Field
{
    private $maxX;
    private $maxY;

    public function setMaxY($y)
    {
        $this->maxY = $y;
    }

    public function getMaxY()
    {
        return $this->maxY;
    }

    public function setMaxX($x)
    {
        $this->maxX =$x;
    }
    
    public function getMaxX()
    {
        return $this->maxX;
    }
}