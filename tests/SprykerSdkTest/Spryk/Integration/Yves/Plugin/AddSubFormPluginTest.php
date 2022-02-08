<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Plugin;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Plugin
 * @group AddSubFormPluginTest
 * Add your own group annotations below this line
 */
class AddSubFormPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsSubFormPlugin(): void
    {
        $this->tester->run($this, [
            '--organization' => 'SprykerShop',
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
        ]);

        $this->assertFileExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Plugin/TestPaymentSubFormPlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsSubFormPluginFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Plugin/TestPaymentSubFormPlugin.php',
        );
    }
}
