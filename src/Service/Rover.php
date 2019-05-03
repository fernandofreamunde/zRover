<?php


namespace App\Service;


use App\Exception\UnsupportedInstruction;

class Rover
{
    private $x;
    private $y;
    /**
     * @var Compass
     */
    private $compass;

    public function __construct(Compass $compass, int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
        $this->compass = $compass;
    }

    public function getPosition()
    {
        return [
            'x' => $this->x,
            'y' => $this->y,
        ];
    }

    public function getReport()
    {
        return [
            $this->x,
            $this->y,
            $this->compass->getDirection(),
        ];
    }

    public function move()
    {
        switch ($this->compass->getDirection()){
            case 'N':
                $this->y++;
                break;
            case 'E':
                $this->x++;
                break;
            case 'S':
                $this->y--;
                break;
            case 'W':
                $this->x--;
                break;
        }
    }

    public function execute(string $instructions)
    {
        $instructions = str_split($instructions);
        foreach ($instructions as $instruction) {
            switch ($instruction){
                case 'M':
                    $this->move();
                    break;
                case 'R':
                    $this->compass->rotateRight();
                    break;
                case 'L':
                    $this->compass->rotateLeft();
                    break;
                default:
                    throw new UnsupportedInstruction('Please use only M to move R to turn right and L to turn Left');
            }
        }
    }
}