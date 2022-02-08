<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunMethodTest
 * Add your own group annotations below this line
 */
class SprykRunMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsApiAnnotation(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddMethodWithApiTag',
            '--mode' => 'core',
        ];

        $tester->execute($arguments);
        $expectedDocBlock = '/**
     * @api
     *
     * @return bool
     */';
        $this->tester->assertDocBlockForClassMethod($expectedDocBlock, 'Spryker\Zed\FooBar\Business\FooBarFacade', 'doSomething');
    }

    /**
     * @return void
     */
    public function testAddsApiAndInheritdocAnnotations(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddMethodWithApiAndInheritdocTag',
            '--mode' => 'core',
        ];

        $tester->execute($arguments);
        $expectedDocBlock = '/**
     * {@inheritDoc}
     *
     * @api
     *
     * @return bool
     */';
        $this->tester->assertDocBlockForClassMethod($expectedDocBlock, 'Spryker\Zed\FooBar\Business\FooBarFacade', 'doSomething');
    }
}
