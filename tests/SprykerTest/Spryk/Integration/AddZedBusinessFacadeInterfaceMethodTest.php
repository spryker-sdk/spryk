<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Zed\FooBar\Business\FooBarFacadeInterface;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Facade
 * @group AddZedBusinessFacadeInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFacadeInterfaceMethodTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedBusinessFacadeInterfaceMethod';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToFacadeInterface(): void
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
        $this->tester->assertClassHasMethod(FooBarFacadeInterface::class, 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsCommentFacadeInterface(): void
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
            '--comment' => [
                'Specification:',
                '- First specification line.',
                '- Second specification line.',
            ],
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $pathToFacadeInterface = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/FooBarFacadeInterface.php';
        $facadeInterfaceContent = file_get_contents($pathToFacadeInterface);

        $this->assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        $this->assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        $this->assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }
}
