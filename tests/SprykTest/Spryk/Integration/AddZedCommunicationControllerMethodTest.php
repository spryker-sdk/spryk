<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedCommunicationControllerMethodTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationControllerMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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
            '--method' => 'indexAction',
        ]);

        $this->tester->assertClassHasMethod(ClassName::CONTROLLER_ZED, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsViewFileForControllerAction(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'indexAction',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsNavigationNodeEntryToNavigationSchema(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'indexAction',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }
}
