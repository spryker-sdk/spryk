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
 * @group SprykRunArgumentDefaultValueTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentDefaultValueTest extends Unit
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
    public function testTakesDefaultArgumentValueOnEnter(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithDefaultArgumentValue',
            '--mode' => 'core',
        ];
        $tester->setInputs([static::KEY_STROKE_ENTER]);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $expectedOutput = 'Enter value for StructureWithDefaultArgumentValue.targetPath argument []';
        $this->assertRegExp('#' . preg_quote($expectedOutput) . '#', $output);

        $this->assertDirectoryExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');
    }
}
