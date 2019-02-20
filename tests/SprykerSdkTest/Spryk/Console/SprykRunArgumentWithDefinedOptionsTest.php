<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentWithDefinedOptionsTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentWithDefinedOptionsTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
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
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--targetPath' => 'vendor/spryker/spryker/Bundles/%module%/',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();

        static::assertNotRegExp('/Enter value for module argument/', $output);
        static::assertNotRegExp('/Enter value for targetPath argument/', $output);

        OptionsContainer::clearOptions();
    }
}
