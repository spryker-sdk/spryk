<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunTemplateTest
 * Add your own group annotations below this line
 */
class SprykRunTemplateTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
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

        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
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

        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer.json');
        $fileContent = file_get_contents($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer.json');
        $fileContent = ($fileContent) ?: '';

        static::assertRegExp('/"name": "spryker\/FooBar"/', $fileContent);
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

        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/new-filename.json');
    }
}
