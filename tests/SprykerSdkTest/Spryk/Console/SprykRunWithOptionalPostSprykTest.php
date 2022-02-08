<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunWithOptionalPostSprykTest
 * Add your own group annotations below this line
 */
class SprykRunWithOptionalPostSprykTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testDoesNotExecutesOptionalPostSpryk(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'SprykWithOptionalPostSpryk',
            '--mode' => 'core',
        ];

        $tester->execute($arguments);

        $this->assertDirectoryExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');

        $this->assertFileNotExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
    }

    /**
     * @return void
     */
    public function testExecutesOptionalPostSpryk(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'SprykWithOptionalPostSpryk',
            '--' . SprykRunConsole::OPTION_INCLUDE_OPTIONALS => ['TemplateWithoutInteraction'],
            '--mode' => 'core',
        ];

        $tester->execute($arguments);

        $this->assertDirectoryExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');

        $this->assertFileExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
    }
}
