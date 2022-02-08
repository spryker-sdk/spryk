<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Plugin;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Plugin
 * @group AddSubFormPluginDataProviderMethodTest
 * Add your own group annotations below this line
 */
class AddSubFormPluginDataProviderMethodTest extends Unit
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
            '--organization' => 'SprykerShop',
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
        ]);

        $this->tester->assertClassHasMethod(ClassName::YVES_PLUGIN_SUB_FORM_PLUGIN, 'createSubFormDataProvider');
    }
}
