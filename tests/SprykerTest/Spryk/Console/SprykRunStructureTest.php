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
 * @group SprykRunStructureTest
 * Add your own group annotations below this line
 */
class SprykRunStructureTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testCreatesStructure()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getRunConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithoutInteraction',
        ];

        $tester->execute($arguments);

        $this->assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/firstDirectory');
        $this->assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/secondDirectory');
    }
}
