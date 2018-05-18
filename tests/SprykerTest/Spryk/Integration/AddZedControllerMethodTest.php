<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Zed\FooBar\Communication\Controller\IndexController;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedControllerMethodTest
 * Add your own group annotations below this line
 */
class AddZedControllerMethodTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedControllerMethod';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedControllerMethod(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->tester->assertClassHasMethod(IndexController::class, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsViewFileForControllerAction(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsNavigationNodeEntryToNavigationSchema(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }
}
