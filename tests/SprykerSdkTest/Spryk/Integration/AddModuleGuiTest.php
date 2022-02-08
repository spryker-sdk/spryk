<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddModuleGuiTest
 * Add your own group annotations below this line
 */
class AddModuleGuiTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGuiModuleDirectories(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertDirectoryExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed');
        $this->assertDirectoryExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Shared');
    }

    /**
     * @return void
     */
    public function testAddsGuiModuleDirectoriesOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertDirectoryExists($this->tester->getProjectModuleDirectory());
        $this->assertDirectoryExists($this->tester->getProjectModuleDirectory('FooBar', 'Shared'));
    }
}
