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
 * @group AddSharedConstantsInterfaceTest
 * Add your own group annotations below this line
 */
class AddSharedConstantsInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsSharedConstantsInterfaceFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Shared/FooBar/FooBarConstants.php');
    }

    /**
     * @return void
     */
    public function testAddsSharedConstantsInterfaceFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Shared')
            . 'FooBarConstants.php'
        );
    }
}
