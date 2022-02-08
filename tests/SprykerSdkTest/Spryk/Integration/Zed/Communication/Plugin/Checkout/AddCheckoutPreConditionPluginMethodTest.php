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
 * @group AddCheckoutPreConditionPluginMethodTest
 * Add your own group annotations below this line
 */
class AddCheckoutPreConditionPluginMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsCheckoutPreConditionPluginMethod(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_CHECKOUT_PRE_CONDITION_PLUGIN, 'checkCondition');
    }

    /**
     * @return void
     */
    public function testAddsCheckoutPreConditionPluginMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_CHECKOUT_PRE_CONDITION_PLUGIN, 'checkCondition');
    }
}
