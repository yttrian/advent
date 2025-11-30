<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Support;

use NunoMaduro\Collision\Provider as CollisionProvider;
use Symfony\Component\Console\Application;

class App
{
    /**
     * Boot the Advent of Code console application
     *
     * @noinspection PhpUnhandledExceptionInspection exceptions must be thrown
     */
    public static function boot(): void
    {
        // Register Collision
        new CollisionProvider()->register();

        // Create and run console application
        $application = new Application('Advent of Code 2024 by yttrian');
        $application->add(new RunCommand());
        $application->run();
    }
}
