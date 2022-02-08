<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddModulePaymentTest
 * Add your own group annotations below this line
 */
class AddModulePaymentTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsModule(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--paymentMethod' => 'FooPayment',
        ]);

        $this->assertDirectoryExists($this->tester->getSprykerModuleDirectory() . 'src');
    }
}
