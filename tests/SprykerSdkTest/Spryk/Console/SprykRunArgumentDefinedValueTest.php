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
 * @group SprykRunArgumentDefinedValueTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentDefinedValueTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testTakesDefinedArgumentValue(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'StructureWithDefinedArgumentValue',
        ];

        $tester->execute($arguments);

        $output = $tester->getDisplay();
        $this->assertNotRegExp('/Enter value for module argument/', $output);
    }
}
