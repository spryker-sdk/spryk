<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Zed\FooBar\Business\FooBarBusinessFactory;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedBusinessModelTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedBusinessModel';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessModel(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--className' => 'FooBar',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/Model/FooBar.php');
    }

    /**
     * @return void
     */
    public function testAddsMethodToZedBusinessFactory(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--className' => 'FooBar',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->tester->assertClassHasMethod(FooBarBusinessFactory::class, 'createFooBar');
    }
}
