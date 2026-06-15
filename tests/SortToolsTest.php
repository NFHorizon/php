<?php

namespace LogicToolkit\Tests;

use LogicToolkit\Tools\SortTools;
use PHPUnit\Framework\TestCase;

class SortToolsTest extends TestCase
{
    public function testSortersReturnAscendingValues(): void
    {
        $tools = new SortTools();
        $input = [7, 3, 7, 1, 9];
        $expected = [1, 3, 7, 7, 9];

        self::assertSame($expected, $tools->insertion($input));
        self::assertSame($expected, $tools->quick($input));
    }
}
