<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Service;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Service
 * @group AddYvesDependencyServiceInterfaceTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyServiceInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesDependencyServiceInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->assertFileExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Dependency/Service/FooBarToZipZapServiceInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsYvesDependencyServiceInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Dependency/Service/FooBarToZipZapServiceInterface.php',
        );
    }
}
