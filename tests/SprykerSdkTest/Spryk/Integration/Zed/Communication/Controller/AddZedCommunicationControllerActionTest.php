<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Controller;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group Controller
 * @group AddZedCommunicationControllerActionTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationControllerActionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedControllerMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'index',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_CONTROLLER, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'index',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_CONTROLLER, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerMethodAndReplacesActionSuffix(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'IndexController',
            '--controllerMethod' => 'indexAction',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_CONTROLLER, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerMethodAndReplacesActionSuffixOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'IndexController',
            '--controllerMethod' => 'indexAction',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_CONTROLLER, 'indexAction');
    }

    /**
     * @group single
     *
     * @return void
     */
    public function testAddsZedControllerMethodToFullyQualifiedControllerClassName(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::ZED_CONTROLLER,
            '--controllerMethod' => 'indexAction',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_CONTROLLER, 'indexAction');
    }

    /**
     * @group single
     *
     * @return void
     */
    public function testAddsZedControllerMethodToFullyQualifiedControllerClassNameOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::PROJECT_ZED_CONTROLLER,
            '--controllerMethod' => 'indexAction',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_CONTROLLER, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsViewFileForControllerAction(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'indexAction',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsViewFileForControllerActionOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'indexAction',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsNavigationNodeEntryToNavigationSchema(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'indexAction',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsNavigationNodeEntryToNavigationSchemaOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'indexAction',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Presentation/Index/index.twig');
    }
}
