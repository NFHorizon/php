<?php

namespace LogicToolkit\Tests;

use LogicToolkit\ConsoleApplication;
use PHPUnit\Framework\TestCase;

class ConsoleApplicationTest extends TestCase
{
    public function testDispatchBuildsSearchResponse(): void
    {
        $app = new ConsoleApplication();

        $result = $app->dispatch([
            'logic-toolkit',
            'search',
            'binary',
            '--list=1,3,5,8',
            '--target=5',
        ]);

        self::assertSame('search binary', $result['command']);
        self::assertSame(2, $result['index']);
        self::assertTrue($result['found']);
    }
}
