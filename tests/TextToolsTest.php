<?php

namespace LogicToolkit\Tests;

use LogicToolkit\Tools\TextTools;
use PHPUnit\Framework\TestCase;

class TextToolsTest extends TestCase
{
    public function testTextChecksIgnoreCaseAndSpacing(): void
    {
        $tools = new TextTools();

        self::assertTrue($tools->isPalindrome('Never odd or even'));
        self::assertTrue($tools->isAnagram('Listen', 'Silent'));
        self::assertFalse($tools->isAnagram('logic', 'toolkit'));
    }
}
