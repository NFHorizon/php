<?php

namespace LogicToolkit\Tools;

class TextTools
{
    public function isPalindrome(string $value): bool
    {
        $normalized = $this->normalize($value);

        return $normalized === strrev($normalized);
    }

    public function isAnagram(string $left, string $right): bool
    {
        $leftLetters = str_split($this->normalize($left));
        $rightLetters = str_split($this->normalize($right));

        sort($leftLetters);
        sort($rightLetters);

        return $leftLetters === $rightLetters;
    }

    private function normalize(string $value): string
    {
        return strtolower(preg_replace('/[^a-z0-9]/i', '', $value) ?? '');
    }
}
