<?php

namespace LogicToolkit\Tests;

use InvalidArgumentException;
use LogicToolkit\Tools\SearchTools;
use PHPUnit\Framework\TestCase;

class SearchToolsTest extends TestCase
{
    public function testLinearSearchReturnsMatchingIndex(): void
    {
        $tools = new SearchTools();

        self::assertSame(2, $tools->linear([4, 7, 9, 12], 9));
        self::assertNull($tools->linear([4, 7, 9, 12], 3));
    }

    public function testBinarySearchRequiresSortedInput(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new SearchTools())->binary([3, 1, 2], 1);
    }
}
