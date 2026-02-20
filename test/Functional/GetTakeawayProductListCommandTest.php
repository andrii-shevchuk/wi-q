<?php

namespace Test\Functional;

use PHPUnit\Framework\TestCase;

class GetTakeawayProductListCommandTest extends TestCase
{
    public function testCommandOutputsCorrectTable()
    {
        $commandPath = __DIR__ . '/../../src/Presentation/Command/GetTakeawayProductListCommand.php';

        ob_start();
        require $commandPath;
        $output = ob_get_clean();

        $expected = <<<TABLE
+----+--------------+
| ID | Name         |
+----+--------------+
| 1  | Large Pizza  |
| 2  | Medium Pizza |
| 3  | Burger       |
| 4  | Chips        |
| 5  | Soup         |
| 6  | Salad        |
+----+--------------+

TABLE;

        $this->assertEquals($expected, $output);
    }
}
