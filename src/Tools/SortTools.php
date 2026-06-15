<?php

namespace LogicToolkit\Tools;

class SortTools
{
    /**
     * @param array<int, int|float> $values
     * @return array<int, int|float>
     */
    public function insertion(array $values): array
    {
        for ($index = 1; $index < count($values); $index++) {
            $current = $values[$index];
            $position = $index - 1;

            while ($position >= 0 && $values[$position] > $current) {
                $values[$position + 1] = $values[$position];
                $position--;
            }

            $values[$position + 1] = $current;
        }

        return array_values($values);
    }

    /**
     * @param array<int, int|float> $values
     * @return array<int, int|float>
     */
    public function quick(array $values): array
    {
        $size = count($values);

        if ($size < 2) {
            return array_values($values);
        }

        $pivot = $values[intdiv($size, 2)];
        $lower = [];
        $equal = [];
        $higher = [];

        foreach ($values as $value) {
            if ($value < $pivot) {
                $lower[] = $value;
            } elseif ($value > $pivot) {
                $higher[] = $value;
            } else {
                $equal[] = $value;
            }
        }

        return array_merge($this->quick($lower), $equal, $this->quick($higher));
    }
}
