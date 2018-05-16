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
 * @group SprykRunCreateModuleTest
 * Add your own group annotations below this line
 */
class SprykRunCreateModuleTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testCreatesModule()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'CreateModule',
            '-n' => true,
        ];

        $tester->setInputs(['FooBar', 'Spryker', "\x0D", "\x0D", "\x0D", "\x0D", "\x0D"]);
        $tester->execute($arguments);

        $this->assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');
    }
}
