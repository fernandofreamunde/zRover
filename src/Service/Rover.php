<?php


namespace App\Service;


use App\Entity\Field;
use App\Exception\UnsupportedInstruction;

class Rover
{
    private $x;
    private $y;
    /**
     * @var Compass
     */
    private $compass;
    /**
     * @var Field
     */
    private $field;

    public function __construct(Compass $compass, Field $field, int $x = 0, int $y = 0)
    {
        $this->x = $x;
        $this->y = $y;
        $this->compass = $compass;
        $this->field = $field;
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
                if ($this->field->getMaxY() == $this->y) {
                    throw new UnsupportedInstruction('Can\'t move out of the field');
                }
                $this->y++;
                break;
            case 'E':
                if ($this->field->getMaxX() == $this->x) {
                    throw new UnsupportedInstruction('Can\'t move out of the field');
                }
                $this->x++;
                break;
            case 'S':
                if (0 == $this->y) {
                    throw new UnsupportedInstruction('Can\'t move out of the field');
                }
                $this->y--;
                break;
            case 'W':
                if (0 == $this->x) {
                    throw new UnsupportedInstruction('Can\'t move out of the field');
                }
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