<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group AddYvesPageTest
 * Add your own group annotations below this line
 */
class AddYvesPageTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesPageFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
        ]);

        $this->assertDirectoryExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Controller');
        $this->assertDirectoryExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Plugin');
        $this->assertDirectoryExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Theme');
    }

    /**
     * @return void
     */
    public function testAddsYvesPageFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--mode' => 'project',
        ]);

        $this->assertDirectoryExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves') . 'Controller',
        );
        $this->assertDirectoryExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves') . 'Plugin',
        );
        $this->assertDirectoryExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves') . 'Theme',
        );
    }
}
