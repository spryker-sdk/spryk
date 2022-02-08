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
 * @group AddZedBusinessTestSuiteTest
 * Add your own group annotations below this line
 */
class AddZedBusinessTestSuiteTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessTestSuiteConfiguration(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertDirectoryExists($this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/Business');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessTestSuiteConfigurationOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertDirectoryExists($this->tester->getProjectTestDirectory());
    }
}
