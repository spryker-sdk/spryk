<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
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

        static::assertDirectoryExists($this->tester->getModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/Business');
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

        static::assertDirectoryExists($this->tester->getProjectTestDirectory());
    }
}
