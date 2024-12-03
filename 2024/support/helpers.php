<?php
declare(strict_types=1);

if (!function_exists('int10')) {
    /**
     * Arity-1 integer conversion
     *
     * @param  mixed  $value
     *
     * @return int base 10 integer
     */
    function int10(mixed $value): int
    {
        return intval($value);
    }
}
