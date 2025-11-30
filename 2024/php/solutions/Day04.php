<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Solutions;

use Generator;
use Illuminate\Support\Collection;
use Yttrian\Advent2024\Support\Solution;

class Day04 implements Solution
{
    /**
     * @param  bool  $x  only return directions that make an X
     *
     * @return Generator<int[]>
     */
    private function directions(bool $x = false): Generator
    {
        for ($i = -1; $i <= 1; $i++) {
            for ($j = -1; $j <= 1; $j++) {
                // If X, only return corners, otherwise return everything including (0, 0) because why not
                if (!$x || ($i !== 0 && $j !== 0)) {
                    yield [$i, $j];
                }
            }
        }
    }

    /**
     * @param  Collection<Collection<string>>  $grid  grid of letters
     * @param  int  $x  current x
     * @param  int  $y  current y
     * @param  array  $direction  direction to look in
     * @param  string  $need  next letters needed
     *
     * @return bool were the needs met?
     */
    private function look(Collection $grid, int $x, int $y, array $direction, string $need): bool
    {
        if (empty($need)) {
            // Look finished successfully!
            return true;
        } elseif (($grid[$y][$x] ?? null) === $need[0]) {
            // Keep looking recursively
            return $this->look($grid, $x + $direction[0], $y + $direction[1], $direction, substr($need, 1));
        } else {
            // No match
            return false;
        }
    }

    /**
     * @param  Collection<string>  $input
     *
     * @return Collection<Collection<string>> grid of letters
     */
    private function toGrid(Collection $input): Collection
    {
        return $input->map(fn(string $row) => collect(str_split($row)));
    }

    public function first(Collection $input): int
    {
        $grid = $this->toGrid($input);
        $count = 0;

        foreach ($grid as $y => $row) {
            foreach ($row as $x => $cell) {
                foreach ($this->directions() as $direction) {
                    // Look in all directions and count if XMAS is found
                    if ($this->look($grid, $x, $y, $direction, 'XMAS')) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }

    public function second(Collection $input): int
    {
        $grid = $this->toGrid($input);
        $count = 0;

        foreach ($grid as $y => $row) {
            foreach ($row as $x => $cell) {
                if ($cell === 'A') {
                    // Pull letters in the X
                    $pulled = collect($this->directions(x: true))
                        ->map(fn($direction) => $grid[$y + $direction[1]][$x + $direction[0]] ?? null);

                    // The X must only contain M and S
                    $onlyCorrectLetters = $pulled->diff(['M', 'S'])->isEmpty();

                    // Opposite sides cannot match (SAS, MAM)
                    $oppositesAreDifferent = $pulled[0] !== $pulled[3] && $pulled[1] !== $pulled[2];

                    // Count if X-MAS
                    if ($onlyCorrectLetters && $oppositesAreDifferent) {
                        $count++;
                    }
                }
            }
        }

        return $count;
    }
}
