<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Business;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Business
 * @group AddZedBusinessFacadeTestTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFacadeTestTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessFacadeTest(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/Business/FooBarFacadeTest.php');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessFacadeTestOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectTestDirectory() . 'Business/FooBarFacadeTest.php');
    }
}
