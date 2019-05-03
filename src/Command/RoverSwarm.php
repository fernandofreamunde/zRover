<?php

namespace App\Command;

use App\Entity\Field;
use App\Service\Compass;
use App\Service\Rover;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RoverSwarm extends Command
{

    protected static $defaultName = 'rover:swarm';

    protected function configure()
    {
        $this->setDescription('Controls many Rovers in Mars');
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Werkspot Mars Rover Swarm');

        $fieldSize = explode(',', $io->ask('What is the field size?', '15,10'));

        if (!is_numeric($fieldSize[0]) || !is_numeric($fieldSize[1])) {
            $io->error('Invalid input');
            exit;
        }

        $field = new Field();
        $field->setMaxX((int) $fieldSize[0]);
        $field->setMaxY((int) $fieldSize[1]);

        $numberOfRovers = $io->ask('How many Rovers should be deployed for this mission?', '2');

        $rovers = [];
        for ($i = 0; $i <= $numberOfRovers -1; $i++) {
            $initialRoverPosition = explode(',', $io->ask('What is the initial position for Rover '.$i.'?', '1,2,N'));
            $rover = new Rover(new Compass($initialRoverPosition[2]), $field, $initialRoverPosition[0], $initialRoverPosition[1]);

            $roverInstructions = $io->ask('What are the rover instructions', 'RMLMLMLMM');

            $rover->execute($roverInstructions);

            $rovers[] = $rover;
        }

        $reports = [];
        $iterator = 0;
        foreach ($rovers as $rover) {
            $reports[] = 'New Rover '.$iterator.' position: ' . implode(',',$rover->getReport());
            $iterator++;
        }

        $io->success(implode("\n",$reports));
    }
}