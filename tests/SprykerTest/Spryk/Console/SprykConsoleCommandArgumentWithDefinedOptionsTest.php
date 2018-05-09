<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykConsoleCommand;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykConsoleCommandArgumentWithDefinedOptionsTest
 * Add your own group annotations below this line
 */
class SprykConsoleCommandArgumentWithDefinedOptionsTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testDoesNotAskForUserInputWhenAllArgumentsFullfilledByPassedOptions()
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'CreateModule',
            '--module' => 'FooBar',
            '--targetPath' => 'vendor/spryker/spryker/Bundles/%module%/',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();

        $this->assertNotRegExp('/Enter value for module argument/', $output);
        $this->assertNotRegExp('/Enter value for targetPath argument/', $output);

        OptionsContainer::clearOptions();
    }
}
