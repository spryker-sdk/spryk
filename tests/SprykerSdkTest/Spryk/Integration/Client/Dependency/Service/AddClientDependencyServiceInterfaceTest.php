<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Client\Dependency\Service;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Client
 * @group Dependency
 * @group Service
 * @group AddClientDependencyServiceInterfaceTest
 * Add your own group annotations below this line
 */
class AddClientDependencyServiceInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsClientDependencyServiceInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Client/FooBar/Dependency/Service/FooBarToZipZapServiceInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsClientDependencyServiceInterfaceOnProjectLayer(): void
    {
        $moduleName = 'FooBar';

        $this->tester->run($this, [
            '--module' => $moduleName,
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory($moduleName, 'Client')
            . 'Dependency/Service/FooBarToZipZapServiceInterface.php'
        );
    }
}
