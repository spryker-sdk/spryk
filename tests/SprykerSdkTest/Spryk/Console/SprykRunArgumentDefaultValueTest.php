<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentDefaultValueTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentDefaultValueTest extends Unit
{
    public const KEY_STROKE_ENTER = "\x0D";

    /**
     * @var \SprykerSdkTest\SprykConsoleTester
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
        $tester->setInputs([static::KEY_STROKE_ENTER]);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $expectedOutput = 'Enter value for StructureWithDefaultArgumentValue.targetPath argument [vendor/spryker/spryker/Bundles/{{ module }}/]';
        static::assertRegExp('#' . preg_quote($expectedOutput) . '#', $output);

        static::assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');
    }
}
