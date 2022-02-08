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
 * @group AddZedCommunicationConsoleTestTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationConsoleTestTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedConsoleTest(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/Communication/Console/FooBarConsoleTest.php');
    }

    /**
     * @return void
     */
    public function testAddsZedConsoleTestOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectTestDirectory() . 'Communication/Console/FooBarConsoleTest.php');
    }
}
