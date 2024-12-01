<?php
declare(strict_types=1);

namespace Yttrian\Advent2024;

use Illuminate\Support\Collection;
use ReflectionClass;

abstract class Solution
{
    function run(): void
    {
        $class = new ReflectionClass($this);
        $class = $class->getShortName();

        $input = __DIR__.'/'.$class.'.txt';
        $input = file_get_contents($input);
        $input = explode("\n", $input);
        $input = collect($input);
        $input->pop();

        print $this->first($input)."\n";
        print $this->second($input)."\n";
    }

    abstract function first(Collection $input);

    abstract function second(Collection $input);
}
