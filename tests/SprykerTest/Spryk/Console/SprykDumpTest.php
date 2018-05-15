<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykDumpConsole;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykDumpTest
 * Add your own group annotations below this line
 */
class SprykDumpTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testDumpsAllSpryks()
    {
        $command = new SprykDumpConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertRegExp('/List of all Spryk definitions/', $output);
    }
}
