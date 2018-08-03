<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Spryk\Exception\ArgumentNotFoundException;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentTest extends Unit
{
    const KEY_STROKE_ENTER = "\x0D";

    /**
     * @var \SprykTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAsksForArgumentValue()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'Structure',
        ];

        $tester->setInputs(['Structure']);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        static::assertRegExp('/Enter value for Structure.module argument/', $output);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenArgumentNotFound()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithMissingArgument',
        ];

        $this->expectException(ArgumentNotFoundException::class);

        $tester->execute($arguments);
    }

    /**
     * @return void
     */
    public function testAsksMultipleTimesForTheSameArgumentButFirstInputIsTakenAsDefault()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'CreateModule',
        ];

        $tester->setInputs(['FooBar', 'Spryker', static::KEY_STROKE_ENTER, static::KEY_STROKE_ENTER, static::KEY_STROKE_ENTER, static::KEY_STROKE_ENTER, static::KEY_STROKE_ENTER]);
        $tester->execute($arguments);

        $output = $tester->getDisplay();

        static::assertRegExp('/Enter value for CreateModule.module argument/', $output);
        static::assertRegExp('/Enter value for AddReadme.module argument \[FooBar\]/', $output);
    }
}
