<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Solutions;

use Illuminate\Support\Collection;
use Yttrian\Advent2024\Support\Solution;

class Day03 implements Solution
{
    private function findMulAndSum(string $line)
    {
        preg_match_all('/mul\((\d+),(\d+)\)/', $line, $matches);

        $first = collect($matches[1])->map(fn($s) => intval($s));
        $second = collect($matches[2])->map(fn($s) => intval($s));

        return $first->zip($second)->mapSpread(fn($a, $b) => $a * $b)->sum();
    }

    public function first(Collection $input)
    {
        return $this->findMulAndSum($input->join(''));
    }

    private function removeDoNot(string $line): string
    {
        return preg_replace('/don\'t\(\).*?(do\(\)|$)/', '', $line);
    }

    public function second(Collection $input)
    {
        return $this->findMulAndSum($this->removeDoNot($input->join('')));
    }
}
