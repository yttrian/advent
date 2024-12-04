<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Solutions;

use Generator;
use Illuminate\Support\Collection;
use Yttrian\Advent2024\Support\Solution;

class Day04 implements Solution
{
    private function directions(): Generator
    {
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                yield [$i, $j];
            }
        }
    }

    private function look(Collection $grid, int $x, int $y, array $direction, string $need): bool
    {
        if (empty($need)) {
            return true;
        } elseif (($grid[$y][$x] ?? null) === $need[0]) {
            return $this->look($grid, $x + $direction[0], $y + $direction[1], $direction, substr($need, 1));
        } else {
            return false;
        }
    }

    private function countXmas(Collection $grid): int
    {
        $count = 0;

        foreach ($grid as $y => $row) {
            foreach ($row as $x => $cell) {
                foreach ($this->directions() as $direction) {
                    if ($this->look($grid, $x, $y, $direction, 'XMAS')) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    private function toGrid(Collection $input): Collection
    {
        return $input->map(fn(string $row) => collect(str_split($row)));
    }

    public function first(Collection $input): int
    {
        return $this->countXmas($this->toGrid($input));
    }

    public function second(Collection $input)
    {
        // TODO: Implement second() method.
    }
}
