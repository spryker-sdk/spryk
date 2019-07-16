<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Processor;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Processor
 * @group ResponseBuilder
 * @group AddGlueResourceRestResponseBuilderModelInterfaceTest
 * Add your own group annotations below this line
 */
class AddGlueResourceRestResponseBuilderModelInterfaceTest extends Unit
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
            '--resourceType' => 'foo-bar',
            '--subDirectory' => 'RestResponseBuilder',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/RestResponseBuilder/FooBarRestResponseBuilderInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessModelInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bar',
            '--subDirectory' => 'RestResponseBuilder',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/RestResponseBuilder/FooBarRestResponseBuilderInterface.php');
    }
}
