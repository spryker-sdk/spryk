<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Client;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Client
 * @group AddYvesDependencyClientInterfaceTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyClientInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesDependencyFacadeInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->assertFileExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Dependency/Client/FooBarToZipZapClientInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsYvesDependencyFacadeInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Dependency/Client/FooBarToZipZapClientInterface.php',
        );
    }
}
