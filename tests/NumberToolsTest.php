<?php

namespace LogicToolkit\Tests;

use InvalidArgumentException;
use LogicToolkit\Tools\NumberTools;
use PHPUnit\Framework\TestCase;

class NumberToolsTest extends TestCase
{
    public function testNumberHelpers(): void
    {
        $tools = new NumberTools();

        self::assertSame(6, $tools->gcd(84, 30));
        self::assertSame(720, $tools->factorial(6));
        self::assertSame(55, $tools->fibonacci(10));
    }

    public function testFactorialRejectsNegativeInput(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new NumberTools())->factorial(-1);
    }
}
