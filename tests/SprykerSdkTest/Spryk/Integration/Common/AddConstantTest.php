<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Common;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Common
 * @group AddConstantTest
 * Add your own group annotations below this line
 */
class AddConstantTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsConstant(): void
    {
        $sprykName = 'AddClient';
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command, $sprykName);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => $sprykName,
            '--module' => 'FooBar',
            '--mode' => 'core',
        ];

        $tester->execute($arguments);

        $constantName = 'CONSTANT_NAME';
        $constantValue = 'CONSTANT_VALUE';
        $constantVisibility = 'protected';

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => $constantName,
            '--value' => $constantValue,
            '--target' => ClassName::CLIENT,
            '--visibility' => $constantVisibility,
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::CLIENT,
            $constantName,
            $constantValue,
            $constantVisibility,
        );
    }
}
