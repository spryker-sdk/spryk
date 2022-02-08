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
 * @group SprykRunArgumentMultiTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentMultiTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMultiArgument(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddFacadeMethod',
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--mode' => 'core',
        ];

        $tester->execute($arguments);

        $pathToFacadeInterface = $this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src/Spryker/Zed/FooBar/Business/FooBarFacadeInterface.php';
        $facadeInterfaceContent = file_get_contents($pathToFacadeInterface);
        $facadeInterfaceContent = ($facadeInterfaceContent) ?: '';

        $this->assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        $this->assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        $this->assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }
}
