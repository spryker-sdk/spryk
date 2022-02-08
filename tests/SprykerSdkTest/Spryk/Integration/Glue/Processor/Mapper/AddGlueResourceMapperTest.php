<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Processor\Mapper;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Processor
 * @group Mapper
 * @group AddGlueResourceMapperTest
 * Add your own group annotations below this line
 */
class AddGlueResourceMapperTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueProcessorModelInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Mapper',
            '--className' => 'FooBarMapper',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Mapper/FooBarMapper.php');
        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Mapper/FooBarMapperInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessModelInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Mapper',
            '--className' => 'FooBarMapper',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Mapper/FooBarMapper.php');
        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Mapper/FooBarMapperInterface.php');
    }
}
