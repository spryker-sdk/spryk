<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Presentation;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Presentation
 * @group AddZedPresentationTwigTest
 * Add your own group annotations below this line
 */
class AddZedPresentationTwigTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedViewFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'index',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsZedViewFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--controllerMethod' => 'index',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Presentation/Index/index.twig',
        );
    }

    /**
     * @return void
     */
    public function testAddsZedViewFileWithFullyQualifiedNames(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::ZED_CONTROLLER,
            '--controllerMethod' => 'indexAction',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsZedViewFileWithFullyQualifiedNamesOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::ZED_CONTROLLER,
            '--controllerMethod' => 'indexAction',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Presentation/Index/index.twig',
        );
    }
}
