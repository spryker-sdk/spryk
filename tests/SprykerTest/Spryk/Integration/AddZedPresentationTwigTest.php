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
 * @group AddZedPresentationTwigTest
 * Add your own group annotations below this line
 */
class AddZedPresentationTwigTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedPresentationTwig';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedViewFile(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }
}
