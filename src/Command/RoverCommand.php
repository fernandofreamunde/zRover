<?php

namespace App\Command;

use App\Entity\Field;
use App\Service\Compass;
use App\Service\Rover;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RoverCommand extends Command
{

    protected static $defaultName = 'rover:control';

    protected function configure()
    {
        $this->setDescription('Controls one Rover in Mars');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Werkspot Mars Rover');

        $fieldSize = explode(',', $io->ask('What is the field size?', '5,5'));

        if (!is_numeric($fieldSize[0]) || !is_numeric($fieldSize[1])) {
            $io->error('Invalid input');
            exit;
        }

        $field = new Field();
        $field->setMaxX((int) $fieldSize[0]);
        $field->setMaxY((int) $fieldSize[1]);

        $initialRoverPosition = explode(',', $io->ask('What is the initial rover position?', '1,2,N'));

        $compass = new Compass($initialRoverPosition[2]);

        $rover = new Rover($compass, $field, $initialRoverPosition[0], $initialRoverPosition[1]);

        $roverInstructions = $io->ask('What are the rover instructions', 'RMLMLMLMM');

        $rover->execute($roverInstructions);

        $io->success('New Rover position: ' . implode(',',$rover->getReport()));
    }
}