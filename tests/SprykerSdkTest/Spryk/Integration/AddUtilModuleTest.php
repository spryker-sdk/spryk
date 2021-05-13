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
 * @group AddUtilModuleTest
 * Add your own group annotations below this line
 */
class AddUtilModuleTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsUtilModuleDirectories(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertDirectoryExists($this->tester->getModuleDirectory() . 'src/Spryker/Shared');
        $this->assertDirectoryExists($this->tester->getModuleDirectory() . 'src/Spryker/Service');
    }

    /**
     * @return void
     */
    public function testAddsUtilModuleDirectoriesOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertDirectoryExists($this->tester->getProjectModuleDirectory('FooBar', 'Shared'));
        $this->assertDirectoryExists($this->tester->getProjectModuleDirectory('FooBar', 'Service'));
    }
}
