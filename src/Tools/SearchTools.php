<?php

namespace LogicToolkit\Tools;

use InvalidArgumentException;

class SearchTools
{
    /**
     * @param array<int, int|float> $values
     * @param int|float $target
     */
    public function linear(array $values, $target): ?int
    {
        foreach ($values as $index => $value) {
            if ($value == $target) {
                return $index;
            }
        }

        return null;
    }

    /**
     * @param array<int, int|float> $values
     * @param int|float $target
     */
    public function binary(array $values, $target): ?int
    {
        $this->assertSorted($values);

        $low = 0;
        $high = count($values) - 1;

        while ($low <= $high) {
            $middle = intdiv($low + $high, 2);

            if ($values[$middle] == $target) {
                return $middle;
            }

            if ($values[$middle] < $target) {
                $low = $middle + 1;
            } else {
                $high = $middle - 1;
            }
        }

        return null;
    }

    /**
     * @param array<int, int|float> $values
     */
    private function assertSorted(array $values): void
    {
        for ($index = 1; $index < count($values); $index++) {
            if ($values[$index - 1] > $values[$index]) {
                throw new InvalidArgumentException('Binary search requires an ascending list');
            }
        }
    }
}
