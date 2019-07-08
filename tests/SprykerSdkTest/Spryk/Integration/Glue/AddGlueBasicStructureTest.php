<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group AddGlueBasicStructureTest
 * Add your own group annotations below this line
 */
class AddGlueBasicStructureTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueConfigConstant(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--fromTransfer' => 'FooBarTransfer',
        ]);

        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/FooBarConfig.php');
        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/FooBarDependencyProvider.php');
        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/FooBarFactory.php');
        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/FooBarsResourceRoutePlugin.php');
        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Controller/FooBarResourceController.php');
        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Mapper/FooBarMapperInterface.php');
        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Mapper/FooBarMapper.php');
        $this->tester->assertClassHasConstant(
            ClassName::GLUE_CONFIG,
            'RESOURCE_FOO_BARS',
            'foo-bars',
            'public'
        );
        $this->tester->assertClassHasMethod(ClassName::GLUE_BUSINESS_FACTORY, 'createFooBarMapper');
        $this->tester->assertClassHasMethod(ClassName::GLUE_RESOURCE_MAPPER, 'mapFooBarTransferToRestFooBarsAttributesTransfer');
    }

    /**
     * @return void
     */
    public function testAddsGlueConfigConstantOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--fromTransfer' => 'FooBarTransfer',
            '--mode' => 'project',
        ]);

        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'FooBarConfig.php');
        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'FooBarDependencyProvider.php');
        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'FooBarFactory.php');
        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/FooBarsResourceRoutePlugin.php');
        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Controller/FooBarResourceController.php');
        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Mapper/FooBarMapperInterface.php');
        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Mapper/FooBarMapper.php');
        $this->tester->assertClassHasConstant(
            ClassName::PROJECT_GLUE_CONFIG,
            'RESOURCE_FOO_BARS',
            'foo-bars',
            'public'
        );
        $this->tester->assertClassHasMethod(ClassName::PROJECT_GLUE_BUSINESS_FACTORY, 'createFooBarMapper');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_GLUE_RESOURCE_MAPPER, 'mapFooBarTransferToRestFooBarsAttributesTransfer');
    }
}
