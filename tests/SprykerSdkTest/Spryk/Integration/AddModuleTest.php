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
 * @group AddModuleTest
 * Add your own group annotations below this line
 */
class AddModuleTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsModule(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        static::assertDirectoryExists($this->tester->getModuleDirectory() . 'src');
    }

    /**
     * @return void
     */
    public function testAddsModuleOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertDirectoryExists($this->tester->getProjectModuleDirectory());
    }
}
