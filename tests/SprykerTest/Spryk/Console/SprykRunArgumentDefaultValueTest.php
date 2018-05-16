<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentDefaultValueTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentDefaultValueTest extends Unit
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
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithDefaultArgumentValue',
        ];
        $tester->setInputs(["\x0D"]);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $expectedOutput = 'Enter value for StructureWithDefaultArgumentValue.targetPath argument [vendor/spryker/spryker/Bundles/%module%/]';
        $this->assertRegExp('#' . preg_quote($expectedOutput) . '#', $output);

        $this->assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');
    }
}
