<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\GlueBackOffice;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group GlueBackOffice
 * @group AddGlueBackOfficeRestResourcePluginTest
 * Add your own group annotations below this line
 */
class AddGlueBackOfficeRestResourcePluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueBackOfficeRestResourcePlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBarBackOffice',
            '--pluginName' => 'FooBarBackOfficeResourcePlugin',
            '--className' => 'FooBarBackOfficeController',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory('FooBarBackOffice') . 'src/Spryker/Glue/FooBarBackOffice/Plugin/GlueBackOffice/FooBarBackOfficeResourcePlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueBackOfficeRestResourcePluginOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBarBackOffice',
            '--mode' => 'project',
            '--pluginName' => 'FooBarBackOfficeResourcePlugin',
            '--className' => 'FooBarBackOfficeController',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBarBackOffice', 'Glue') . 'Plugin/GlueBackOffice/FooBarBackOfficeResourcePlugin.php');
    }
}
