<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddClientTest
 * Add your own group annotations below this line
 */
class AddClientTest extends Unit
{
    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testCreatesChangeLogFile()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, 'AddClient');

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddClient',
            '--module' => 'FooBar',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Client/FooBar/FooBarClient.php');
    }
}
