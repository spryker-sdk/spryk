<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Spryk\Exception\CallbackNotFoundException;
use Spryker\Zed\FooBar\Business\FooBarBusinessFactory;

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
     * @var \SprykerTest\SprykTester
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
            '--module' => 'FooBar',
            '--moduleOrganization' => 'Spryker',
            '--output' => 'Spryker',
        ];

        $tester->execute($arguments, ['interactive' => false]);

        $this->tester->assertClassHasMethod(FooBarBusinessFactory::class, 'createFooBar');
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
            '--module' => 'FooBar',
            '--moduleOrganization' => 'Spryker',
        ];

        $this->expectException(CallbackNotFoundException::class);
        $tester->execute($arguments, ['interactive' => false]);
    }
}
