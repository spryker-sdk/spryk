<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Client;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Client
 * @group AddZedDependencyClientInterfaceTest
 * Add your own group annotations below this line
 */
class AddZedDependencyClientInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedDependencyFacadeInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Dependency/Client/FooBarToZipZapClientInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsZedDependencyFacadeInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Dependency/Client/FooBarToZipZapClientInterface.php',
        );
    }
}
