<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Spryk\Exception\CallbackNotFoundException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentCallbackTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentCallbackTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAppliesCallback(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddZedBusinessFactoryMethod',
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--output' => 'Spryker',
            '--mode' => 'core',
        ];

        $tester->execute($arguments, ['interactive' => false]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createFooBar');
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenCallbackNotFound(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddZedBusinessFactoryMethodWithUndefinedCallback',
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ];

        $this->expectException(CallbackNotFoundException::class);

        $tester->execute($arguments, ['interactive' => false]);
    }
}
