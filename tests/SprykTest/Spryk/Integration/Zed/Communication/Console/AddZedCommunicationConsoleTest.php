<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Communication\Console;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Console
 * @group AddZedCommunicationConsoleTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationConsoleTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedConsole(): void
    {
        $this->tester->run($this, [
            '--moduleName' => 'FooBar',
            '--className' => 'FooBar',
            '--consoleCommand' => 'spryker:spryker',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Console/FooBarConsole.php');
    }
}
