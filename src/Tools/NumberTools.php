<?php

namespace LogicToolkit\Tools;

use InvalidArgumentException;

class NumberTools
{
    public function gcd(int $a, int $b): int
    {
        $a = abs($a);
        $b = abs($b);

        while ($b !== 0) {
            $next = $a % $b;
            $a = $b;
            $b = $next;
        }

        return $a;
    }

    public function factorial(int $value): int
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Factorial is only defined for non-negative integers');
        }

        $result = 1;
        for ($number = 2; $number <= $value; $number++) {
            $result *= $number;
        }

        return $result;
    }

    public function fibonacci(int $value): int
    {
        if ($value < 0) {
            throw new InvalidArgumentException('Fibonacci is only defined for non-negative integers');
        }

        $previous = 0;
        $current = 1;

        for ($index = 0; $index < $value; $index++) {
            [$previous, $current] = [$current, $previous + $current];
        }

        return $previous;
    }
}
