<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Plugin\Checkout;

use Codeception\Test\Unit;

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
 * @group AddCheckoutDoSaveOrderPluginTest
 * Add your own group annotations below this line
 */
class AddCheckoutDoSaveOrderPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsCheckoutDoSaveOrderPlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Plugin/Checkout/TestPaymentCheckoutDoSaveOrderPlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsCheckoutDoSaveOrderPluginFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Plugin/Checkout/TestPaymentCheckoutDoSaveOrderPlugin.php');
    }
}
