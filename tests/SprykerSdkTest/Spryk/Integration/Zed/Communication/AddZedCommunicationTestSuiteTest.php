<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddZedCommunicationTestSuiteTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationTestSuiteTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedCommunicationTestSuiteConfiguration(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        static::assertDirectoryExists($this->tester->getModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/Communication');
    }

    /**
     * @return void
     */
    public function testAddsZedCommunicationTestSuiteConfigurationOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertDirectoryExists($this->tester->getProjectTestDirectory());
    }
}
