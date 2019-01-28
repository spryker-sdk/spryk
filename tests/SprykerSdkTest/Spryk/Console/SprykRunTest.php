<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Spryk\Exception\BuilderNotFoundException;
use SprykerSdk\Spryk\Exception\SprykConfigFileNotFound;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Auto-generated group annotations
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
    public function testOutputsSprykNameWhenVerbose()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithoutInteraction',
        ];

        $tester->execute($arguments, ['verbosity' => OutputInterface::VERBOSITY_VERBOSE]);

        $output = $tester->getDisplay();
        static::assertRegExp('/Build StructureWithoutInteraction Spryk/', $output);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenBuilderBySprykNameNotFound()
    {
        $command = new SprykRunConsole();
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
    public function testThrowsExceptionWhenSprykConfigFileNotFound()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'NotExistingSprykName',
        ];

        $this->expectException(SprykConfigFileNotFound::class);
        $tester->execute($arguments);
    }

    /**
     * @return void
     */
    public function testDoesNotRunIntoRecursionWhenCalledSprykCallsPostSprykWhichHasPreviouslyExecutedSprykAsPostSpryk()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'SprykWithRecursion2',
        ];

        $tester->execute($arguments);

        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer.json');
        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
    }
}
