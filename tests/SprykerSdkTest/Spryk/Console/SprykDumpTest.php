<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykDumpConsole;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykDumpTest
 * Add your own group annotations below this line
 */
class SprykDumpTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
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
        static::assertRegExp('/List of all Spryk definitions/', $output);
    }
}
