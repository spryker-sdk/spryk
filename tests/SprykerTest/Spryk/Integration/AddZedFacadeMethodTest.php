<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Zed\FooBar\Business\FooBarFacade;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Facade
 * @group AddZedFacadeMethodTest
 * Add your own group annotations below this line
 */
class AddZedFacadeMethodTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedFacadeMethod';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToFacade(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->tester->assertClassHasMethod(FooBarFacade::class, 'addSomething');
    }
}
