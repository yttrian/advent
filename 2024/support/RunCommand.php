<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Support;

use ReflectionClass;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'run', description: 'Run Advent of Code solutions')]
class RunCommand extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $day = $input->getArgument('day');
        $day = str_pad($day, 2, '0', STR_PAD_LEFT);

        $solution = "\Yttrian\Advent2024\Solutions\Day$day";
        $solution = new $solution();

        $output->writeln("Running Day $day...");
        $this->runSolution($solution, $output);

        return Command::SUCCESS;
    }

    protected function runSolution(Solution $solution, OutputInterface $output): void
    {
        $class = new ReflectionClass($solution);
        $class = $class->getShortName();

        $input = __DIR__.'/../inputs/'.$class.'.txt';
        $input = file_get_contents($input);
        $input = explode("\n", $input);
        $input = collect($input);
        $input->pop();

        $output->writeln("Output 1: ".$solution->first($input));
        $output->writeln("Output 2: ".$solution->second($input));
    }

    protected function configure(): void
    {
        $this->addArgument('day', InputArgument::REQUIRED);
    }
}
