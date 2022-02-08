<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Spryk\Exception\ArgumentNotFoundException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentTest extends Unit
{
    /**
     * @var string
     */
    public const KEY_STROKE_ENTER = "\x0D";

    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAsksForArgumentValue(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'Structure',
            '--mode' => 'core',
        ];

        $tester->setInputs(['Structure']);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertRegExp('/Enter value for Structure.module argument/', $output);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenArgumentNotFound(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithMissingArgument',
            '--mode' => 'core',
        ];

        $this->expectException(ArgumentNotFoundException::class);

        $tester->execute($arguments);
    }

    /**
     * @return void
     */
    public function testAsksMultipleTimesForTheSameArgumentButFirstInputIsTakenAsDefault(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddModule',
            '--mode' => 'core',
        ];

        $tester->setInputs(array_merge(['FooBar', 'Spryker'], array_fill(2, 13, static::KEY_STROKE_ENTER)));
        $tester->execute($arguments);

        $output = $tester->getDisplay();

        $this->assertRegExp('/Enter value for AddModule.module argument/', $output);
        $this->assertRegExp('/Enter value for AddReadme.module argument \[FooBar\]/', $output);
    }
}
