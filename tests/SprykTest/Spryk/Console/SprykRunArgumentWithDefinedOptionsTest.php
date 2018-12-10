<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Console;

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
     * @var \SprykTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testDoesNotAskForUserInputWhenAllArgumentsGivenFromUser()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddModule',
            '--moduleName' => 'FooBar',
            '--organization' => 'Spryker',
            '--targetPath' => 'vendor/spryker/spryker/Bundles/%moduleName%/',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();

        static::assertNotRegExp('/Enter value for module argument/', $output);
        static::assertNotRegExp('/Enter value for targetPath argument/', $output);

        OptionsContainer::clearOptions();
    }
}
