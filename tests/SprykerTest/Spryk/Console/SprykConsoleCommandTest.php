<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykConsoleCommand;
use Spryker\Spryk\Exception\BuilderNotFoundException;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykConsoleCommandTest
 * Add your own group annotations below this line
 */
class SprykConsoleCommandTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testOutputsSprykNameWhenExecuted()
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'StructureWithoutInteraction',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertRegExp('/Spryk StructureWithoutInteraction/', $output);
        $this->assertNotRegExp('/Dry-run: Spryk StructureWithoutInteraction/', $output);
    }

    /**
     * @return void
     */
    public function testDryRun()
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'StructureWithoutInteraction',
            '--' . SprykConsoleCommand::OPTION_DRY_RUN => true,
        ];

        $tester->setInputs(['FooBar']);
        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertRegExp('/Dry-run: Spryk StructureWithoutInteraction/', $output);
    }

    /**
     * @return void
     */
    public function testThrowsExceptionWhenBuilderBySprykNameNotFound()
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'SprykDefinitionWithUndefinedSpryk',
        ];

        $this->expectException(BuilderNotFoundException::class);
        $tester->execute($arguments);
    }
}
