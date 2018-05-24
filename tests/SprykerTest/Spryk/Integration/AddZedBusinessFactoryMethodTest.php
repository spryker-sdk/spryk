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
 * @group AddZedBusinessFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFactoryMethodTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedBusinessFactoryMethod';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessFactory(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--className' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
            '--output' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->tester->assertClassHasMethod(FooBarBusinessFactory::class, 'createFooBar');
    }
}
