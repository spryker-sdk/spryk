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
 * @group SprykRunTemplateTest
 * Add your own group annotations below this line
 */
class SprykRunTemplateTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testCreatesTemplate(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'TemplateWithoutInteraction',
        ];

        $tester->execute($arguments);

        $this->assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
    }

    /**
     * @return void
     */
    public function testReplacesContentInTemplate(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'TemplateWithPlaceholder',
        ];

        $tester->setInputs(['FooBar']);
        $tester->execute($arguments);

        $this->assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer.json');

        $this->assertRegExp(
            '/"name": "spryker\/FooBar"/',
            file_get_contents($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer.json')
        );
    }

    /**
     * @return void
     */
    public function testsUsesDefinedTargetFileName(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'TemplateWithTargetFileName',
        ];

        $tester->setInputs(['FooBar']);
        $tester->execute($arguments);

        $this->assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/new-filename.json');
    }
}
