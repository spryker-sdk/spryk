<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentWithDefinedOptionsTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentWithDefinedOptionsTest extends Unit
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
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'CreateModule',
            '--module' => 'FooBar',
            '--moduleOrganization' => 'Spryker',
            '--targetPath' => 'vendor/spryker/spryker/Bundles/%module%/',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();

        $this->assertNotRegExp('/Enter value for module argument/', $output);
        $this->assertNotRegExp('/Enter value for targetPath argument/', $output);

        OptionsContainer::clearOptions();
    }
}
