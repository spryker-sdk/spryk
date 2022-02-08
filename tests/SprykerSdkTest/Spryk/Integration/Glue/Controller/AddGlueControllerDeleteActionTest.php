<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Controller;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Controller
 * @group AddGlueControllerDeleteActionTest
 * Add your own group annotations below this line
 */
class AddGlueControllerDeleteActionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueControllerAction(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Bar',
            '--resourceType' => 'foo-bars',
            '--modelName' => 'FooBar',
            '--modelSuffix' => 'Deleter',
            '--subDirectory' => 'FooBar',
            '--className' => 'FooBarDeleter',
            '--controllerMethod' => 'deleteAction',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Controller/BarController.php');
        $this->tester->assertClassHasMethod(ClassName::GLUE_CONTROLLER, 'deleteAction');
        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/FooBar/FooBarDeleter.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueControllerOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Bar',
            '--resourceType' => 'foo-bars',
            '--modelName' => 'FooBar',
            '--modelSuffix' => 'Deleter',
            '--subDirectory' => 'FooBar',
            '--className' => 'FooBarDeleter',
            '--controllerMethod' => 'deleteAction',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Controller/BarController.php');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_GLUE_CONTROLLER, 'deleteAction');
        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/FooBar/FooBarDeleter.php');
    }
}
