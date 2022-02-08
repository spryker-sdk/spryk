<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Plugin\Oms;

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
 * @group Oms
 * @group AddCommandByOrderPluginMethodTest
 * Add your own group annotations below this line
 */
class AddCommandByOrderPluginMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsCommandByOrderPluginMethod(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_PLUGIN_OMS_COMMAND_BY_ORDER_PLUGIN, 'run');
    }

    /**
     * @return void
     */
    public function testAddsCommandByOrderPluginMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_PLUGIN_OMS_COMMAND_BY_ORDER_PLUGIN, 'run');
    }
}
