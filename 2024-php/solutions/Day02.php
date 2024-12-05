<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Solutions;

use Illuminate\Support\Collection;
use Yttrian\Advent2024\Support\Solution;

class Day02 implements Solution
{
    private function reports(Collection $input): Collection
    {
        return $input->map(fn(string $s) => array_map('intval', explode(' ', $s)));
    }

    private function isSafe(array $report): bool
    {
        $diffs = collect($report)->sliding()->mapSpread(fn(int $a, int $b) => $a - $b);
        $allIncreasing = $diffs->every(fn($i) => $i > 0);
        $allDecreasing = $diffs->every(fn($i) => $i < 0);
        $belowMax = $diffs->every(fn($i) => abs($i) <= 3);

        return ($allIncreasing || $allDecreasing) && $belowMax;
    }

    public function first(Collection $input): int
    {
        $reports = $this->reports($input);

        return $reports->filter($this->isSafe(...))->count();
    }

    private function canBeSafe(array $report): bool
    {
        for ($i = 0; $i < count($report); $i++) {
            $copy = $report;
            unset($copy[$i]);

            if ($this->isSafe($copy)) {
                return true;
            }
        }

        return false;
    }

    public function second(Collection $input): int
    {
        $reports = $this->reports($input);

        return $reports->filter($this->canBeSafe(...))->count();
    }
}
