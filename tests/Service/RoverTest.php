<?php

namespace App\Tests\Service;

use App\Exception\UnsupportedInstruction;
use App\Service\Compass;
use App\Service\Rover;
use PHPUnit\Framework\TestCase;

class RoverTest extends TestCase
{
    private $rover;
    private $roverWithPosition;
    private $compass;

    public function setUp(): void
    {
        $this->compass = $this->createMock(Compass::class);
        $this->rover = new Rover($this->compass);
        $this->roverWithPosition = new Rover($this->compass, 5, 5);
    }

    public function testGettingInitialPosition()
    {
        $this->assertSame(['x' => 0,'y' => 0], $this->rover->getPosition());
    }

    public function testGettingReport()
    {
        $this->compass->method('getDirection')->willReturn('N');

        $this->assertSame([0, 0, 'N'], $this->rover->getReport());
    }

    public function testRoverMovesNorth()
    {
        $this->compass->method('getDirection')->willReturn('N');

        $this->roverWithPosition->move();

        $this->assertSame(['x' => 5,'y' => 6], $this->roverWithPosition->getPosition());
    }

    public function testRoverMovesEast()
    {
        $this->compass->method('getDirection')->willReturn('E');

        $this->roverWithPosition->move();

        $this->assertSame(['x' => 6,'y' => 5], $this->roverWithPosition->getPosition());
    }

    public function testRoverMovesSouth()
    {
        $this->compass->method('getDirection')->willReturn('S');

        $this->roverWithPosition->move();

        $this->assertSame(['x' => 5,'y' => 4], $this->roverWithPosition->getPosition());
    }

    public function testRoverMovesWest()
    {
        $this->compass->method('getDirection')->willReturn('W');

        $this->roverWithPosition->move();

        $this->assertSame(['x' => 4,'y' => 5], $this->roverWithPosition->getPosition());
    }

    public function testRoverExecutesInstructions()
    {
        $this->compass->method('getDirection')
            ->will($this->onConsecutiveCalls('N','N','E','E','N','N','W','S','E','E','E','E','N','N','N'));

        $this->rover->execute('MMRMMLMMLMLMLMMMMLMM');

        $this->assertSame([5, 5, 'N'], $this->rover->getReport());
    }

    public function testSettingBadInitialDirection()
    {
        $this->expectException(UnsupportedInstruction::class);
        $this->rover->execute('W');
    }
}