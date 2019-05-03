<?php

namespace App\Tests\Service;

use App\Exception\UnsupportedCardinalPoint;
use App\Service\Compass;
use PHPUnit\Framework\TestCase;

class CompassTest extends TestCase
{
    public function testGettingDirection()
    {
        $compass = new Compass();

        $this->assertSame('N', $compass->getDirection());
    }

    public function testRotatingRight()
    {
        $compass = new Compass();
        $compass->rotateRight();
        $this->assertSame('E', $compass->getDirection());
    }

    public function testRotatingRightFourTimes()
    {
        $compass = new Compass();
        $compass->rotateRight();
        $compass->rotateRight();
        $compass->rotateRight();
        $compass->rotateRight();
        $this->assertSame('N', $compass->getDirection());
    }

    public function testRotatingLeft()
    {
        $compass = new Compass();
        $compass->rotateLeft();
        $this->assertSame('W', $compass->getDirection());
    }

    public function testRotatingLeftFourTimes()
    {
        $compass = new Compass();
        $compass->rotateLeft();
        $compass->rotateLeft();
        $compass->rotateLeft();
        $compass->rotateLeft();
        $this->assertSame('N', $compass->getDirection());
    }

    public function testSettingInitialDirection()
    {
        $compass = new Compass('W');
        $this->assertSame('W', $compass->getDirection());
    }

    public function testSettingBadInitialDirection()
    {
        $this->expectException(UnsupportedCardinalPoint::class);
        new Compass('NW');
    }
}