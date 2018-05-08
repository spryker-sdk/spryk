<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykConsoleCommand;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykConsoleCommandArgumentDefaultValueTest
 * Add your own group annotations below this line
 */
class SprykConsoleCommandArgumentDefaultValueTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testTakesDefaultArgumentValueOnEnter()
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'StructureWithDefaultArgumentValue',
        ];
        $tester->setInputs(["\x0D"]);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertRegExp('/Enter value for targetPath argument \[defaultValue\]/', $output);

        $this->assertDirectoryExists($this->tester->getRootDirectory() . 'defaultValue');
    }
}
