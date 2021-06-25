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
 * @group SprykRunAddModuleTest
 * Add your own group annotations below this line
 */
class SprykRunAddModuleTest extends Unit
{
    public const KEY_STROKE_ENTER = "\x0D";

    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testCreatesModule(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddModule',
            '-n' => true,
        ];

        $tester->setInputs(array_merge(['FooBar', 'Spryker'], array_fill(2, 13, static::KEY_STROKE_ENTER)));
        $tester->execute($arguments);

        $this->assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');
    }
}
