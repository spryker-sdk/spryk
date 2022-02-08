<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykDumpConsole;

/**
 * Auto-generated group annotations
 *
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
    public function testDumpsAllSpryks(): void
    {
        $command = $this->createSprykDumpConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();

        $this->assertRegExp('/List of Spryk definitions/', $output);
    }

    /**
     * @return void
     */
    public function testDumpsSpecificSpryk(): void
    {
        $command = $this->createSprykDumpConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykDumpConsole::ARGUMENT_SPRYK => 'AddModule',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertRegExp('/List of all "AddModule" options/', $output);
    }

    /**
     * @return \SprykerSdk\Spryk\Console\SprykDumpConsole
     */
    protected function createSprykDumpConsole(): SprykDumpConsole
    {
        return $this->tester->getClass(SprykDumpConsole::class);
    }
}
