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
 * @group AddYvesModuleTest
 * Add your own group annotations below this line
 */
class AddYvesModuleTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesModuleDirectories(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertDirectoryExists($this->tester->getModuleDirectory() . 'src/Spryker/Yves');
        $this->assertDirectoryExists($this->tester->getModuleDirectory() . 'src/Spryker/Shared');
    }

    /**
     * @return void
     */
    public function testAddsYvesModuleDirectoriesOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertDirectoryExists($this->tester->getProjectModuleDirectory('FooBar', 'Yves'));
        $this->assertDirectoryExists($this->tester->getProjectModuleDirectory('FooBar', 'Shared'));
    }
}
