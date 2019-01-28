<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Console;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
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
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedConsole(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBar',
            '--consoleCommand' => 'spryker:spryker',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Console/FooBarConsole.php');
    }

    /**
     * @return void
     */
    public function testAddsZedConsoleOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBar',
            '--consoleCommand' => 'spryker:spryker',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Console/FooBarConsole.php');
    }
}
