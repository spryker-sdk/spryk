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
 * @group AddZedBusinessFactoryTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFactoryTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessFactoryFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/FooBarBusinessFactory.php');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessFactoryFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . 'Business/FooBarBusinessFactory.php');
    }
}
