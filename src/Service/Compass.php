<?php

namespace App\Service;

use App\Exception\UnsupportedCardinalPoint;

class Compass
{
    private $directionIndex = 0;
    private $cardinalPoints = ['N', 'E', 'S', 'W'];

    public function __construct(string $direction = 'N')
    {
        if (!in_array($direction, $this->cardinalPoints)) {
            throw new UnsupportedCardinalPoint();
        }

        $this->directionIndex = array_search($direction, $this->cardinalPoints);
    }

    public function getDirection()
    {
        return $this->cardinalPoints[$this->directionIndex];
    }

    public function rotateRight()
    {
        $this->directionIndex++;

        if ($this->directionIndex > 3) {
            $this->directionIndex = 0;
        }
    }

    public function rotateLeft()
    {
        $this->directionIndex--;

        if ($this->directionIndex < 0) {
            $this->directionIndex = 3;
        }
    }
}