<?php
declare(strict_types=1);

namespace Yttrian\Advent2024;

use Illuminate\Support\Collection;

class Day01 extends Solution
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
