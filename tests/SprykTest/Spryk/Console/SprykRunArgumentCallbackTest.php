<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Spryk\Exception\CallbackNotFoundException;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentCallbackTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentCallbackTest extends Unit
{
    /**
     * @var \SprykTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAppliesCallback(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddZedBusinessFactoryMethod',
            '--moduleName' => 'FooBar',
            '--organization' => 'Spryker',
            '--output' => 'Spryker',
        ];

        $tester->execute($arguments, ['interactive' => false]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createFooBar');
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenCallbackNotFound(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddZedBusinessFactoryMethodWithUndefinedCallback',
            '--moduleName' => 'FooBar',
            '--organization' => 'Spryker',
        ];

        $this->expectException(CallbackNotFoundException::class);
        $tester->execute($arguments, ['interactive' => false]);
    }
}
