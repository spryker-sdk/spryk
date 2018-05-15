<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

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
    /**
     * @var \SprykerTest\SprykTester
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
        $this->assertRegExp('/Enter value for Structure.module argument/', $output);
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

        $tester->setInputs([
            // First answer for module
            'FooBar',
            // First answer for moduleOrganization
            'Spryker',
            // Use default for targetPath (hit enter)
            "\x0D",
            // Re-use first answer for module (hit enter)
            "\x0D",
            // Use default for targetPath (hit enter)
            "\x0D",
            // Re-use first answer for module (hit enter)
            "\x0D",
            // Use default for targetPath (hit enter)
            "\x0D",
        ]);
        $tester->execute($arguments);

        $output = $tester->getDisplay();

        $this->assertRegExp('/Enter value for CreateModule.module argument/', $output);
        $this->assertRegExp('/Enter value for AddReadme.module argument \[FooBar\]/', $output);
    }
}
