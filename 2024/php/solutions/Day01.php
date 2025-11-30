<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Solutions;

use Illuminate\Support\Collection;
use Yttrian\Advent2024\Support\Solution;

class Day01 implements Solution
{
    private function lists(Collection $input): array
    {
        $left = [];
        $right = [];

        foreach ($input as $line) {
            [$l, $r] = explode('   ', $line);
            $left[] = intval($l);
            $right[] = intval($r);
        }

        sort($left);
        sort($right);

        return [$left, $right];
    }

    public function first(Collection $input)
    {
        [$left, $right] = $this->lists($input);

        return collect($left)->zip($right)->sum(fn($v) => abs($v[0] - $v[1]));
    }

    public function second(Collection $input)
    {
        [$left, $right] = $this->lists($input);
        $counts = collect($right)->countBy();

        return collect($left)->sum(fn($v) => $v * $counts->get($v, 0));
    }
}
