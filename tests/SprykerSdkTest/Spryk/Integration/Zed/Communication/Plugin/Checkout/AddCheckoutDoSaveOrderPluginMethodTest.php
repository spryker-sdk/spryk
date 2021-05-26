<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Plugin\Checkout;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group Plugin
 * @group Checkout
 * @group AddCheckoutDoSaveOrderPluginMethodTest
 * Add your own group annotations below this line
 */
class AddCheckoutDoSaveOrderPluginMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddMethod(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--paymentMethod' => 'TestPayment',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_CHECKOUT_DO_SAVE_ORDER_PLUGIN, 'saveOrder');
    }
}
