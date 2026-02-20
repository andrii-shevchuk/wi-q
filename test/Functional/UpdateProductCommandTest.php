<?php

namespace Test\Functional;

use PHPUnit\Framework\TestCase;

class UpdateProductCommandTest extends TestCase
{
    public function testCommandOutputsUpdatedProductTable()
    {
        $commandPath = __DIR__ . '/../../src/Presentation/Command/UpdateProductCommand.php';

        ob_start();
        require $commandPath;
        $output = ob_get_clean();

        $expected = <<<TABLE
+----+-------+
| ID | Name  |
+----+-------+
| 84 | Chips |
+----+-------+

TABLE;

        $this->assertEquals($expected, $output);
    }
}
