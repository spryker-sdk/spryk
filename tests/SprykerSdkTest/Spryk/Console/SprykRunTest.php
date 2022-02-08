<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Spryk\Exception\BuilderNotFoundException;
use SprykerSdk\Spryk\Exception\SprykConfigFileNotFoundException;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunTest
 * Add your own group annotations below this line
 */
class SprykRunTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testOutputsSprykNameWhenVerbose(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithoutInteraction',
        ];

        $tester->execute($arguments, ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);

        $output = $tester->getDisplay();
        $this->assertRegExp('/Build StructureWithoutInteraction Spryk/', $output);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenBuilderBySprykNameNotFound(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'SprykDefinitionWithUndefinedSpryk',
        ];

        $this->expectException(BuilderNotFoundException::class);

        $tester->execute($arguments);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenSprykConfigFileNotFound(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'NotExistingSprykName',
        ];

        $this->expectException(SprykConfigFileNotFoundException::class);

        $tester->execute($arguments);
    }

    /**
     * @return void
     */
    public function testDoesNotRunIntoRecursionWhenCalledSprykCallsPostSprykWhichHasPreviouslyExecutedSprykAsPostSpryk(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'SprykWithRecursion2',
            '--mode' => 'core',
        ];

        $tester->execute($arguments);

        $this->assertFileExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer.json');
        $this->assertFileExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
    }
}
