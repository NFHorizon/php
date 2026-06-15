<?php

namespace LogicToolkit\Support;

use InvalidArgumentException;

class InputParser
{
    /**
     * @param array<int, string> $tokens
     * @return array<string, string>
     */
    public function parseOptions(array $tokens): array
    {
        $options = [];

        foreach ($tokens as $token) {
            if (strpos($token, '--') !== 0) {
                throw new InvalidArgumentException("Invalid option format: {$token}");
            }

            $pair = explode('=', substr($token, 2), 2);
            if (count($pair) !== 2 || $pair[0] === '') {
                throw new InvalidArgumentException("Options must use --name=value syntax");
            }

            $options[$pair[0]] = $pair[1];
        }

        return $options;
    }

    /**
     * @return array<int, int|float>
     */
    public function numberList(string $value): array
    {
        if (trim($value) === '') {
            throw new InvalidArgumentException('A non-empty --list value is required');
        }

        $numbers = [];
        foreach (explode(',', $value) as $item) {
            $numbers[] = $this->number(trim($item), 'list');
        }

        return $numbers;
    }

    /**
     * @return int|float
     */
    public function number(?string $value, string $name)
    {
        if ($value === null || trim($value) === '' || !is_numeric($value)) {
            throw new InvalidArgumentException("Option --{$name} must be numeric");
        }

        return strpos($value, '.') === false ? (int) $value : (float) $value;
    }

    public function integer(?string $value, string $name): int
    {
        if ($value === null || !preg_match('/^-?\d+$/', $value)) {
            throw new InvalidArgumentException("Option --{$name} must be an integer");
        }

        return (int) $value;
    }
}
