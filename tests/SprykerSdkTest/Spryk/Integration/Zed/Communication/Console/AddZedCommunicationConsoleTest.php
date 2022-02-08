<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Console;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
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

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Console/FooBarConsole.php');
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

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Console/FooBarConsole.php');
    }
}
