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
 * @group Facade
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
    public function testAddsZedBusinessFacade(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/Business/FooBarFacadeTest.php');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessFacadeOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectTestDirectory() . 'Business/FooBarFacadeTest.php');
    }
}
