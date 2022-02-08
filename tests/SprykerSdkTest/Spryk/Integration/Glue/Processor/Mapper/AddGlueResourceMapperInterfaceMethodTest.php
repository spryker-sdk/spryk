<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Processor\Mapper;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Processor
 * @group Mapper
 * @group AddGlueResourceMapperInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddGlueResourceMapperInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueResourceMapperMethodWithDefaultFromTransferValue(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--toTransfer' => 'BarQuxTransfer',
            '--mode' => 'core',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Mapper/FooBarMapperInterface.php');
        $this->tester->assertClassHasMethod(ClassName::GLUE_RESOURCE_MAPPER_INTERFACE, 'mapRestFooBarsAttributesTransferToBarQuxTransfer');
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceMapperMethodWithDefaultFromTransferValueOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--toTransfer' => 'BarQuxTransfer',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Mapper/FooBarMapperInterface.php');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_GLUE_RESOURCE_MAPPER_INTERFACE, 'mapRestFooBarsAttributesTransferToBarQuxTransfer');
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceMapperMethodWithDefaultToTransferValue(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--fromTransfer' => 'BarQuxTransfer',
            '--mode' => 'core',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Mapper/FooBarMapperInterface.php');
        $this->tester->assertClassHasMethod(ClassName::GLUE_RESOURCE_MAPPER_INTERFACE, 'mapBarQuxTransferToRestFooBarsAttributesTransfer');
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceMapperMethodWithDefaultToTransferValueOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--fromTransfer' => 'BarQuxTransfer',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Mapper/FooBarMapperInterface.php');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_GLUE_RESOURCE_MAPPER_INTERFACE, 'mapBarQuxTransferToRestFooBarsAttributesTransfer');
    }
}
