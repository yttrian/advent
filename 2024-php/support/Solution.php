<?php
declare(strict_types=1);

namespace Yttrian\Advent2024\Support;

use Illuminate\Support\Collection;

interface Solution
{
    public function first(Collection $input);

    public function second(Collection $input);
}
