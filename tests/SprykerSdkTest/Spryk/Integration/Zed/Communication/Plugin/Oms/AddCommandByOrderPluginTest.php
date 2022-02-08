<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Plugin\Oms;

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
 * @group Oms
 * @group AddCommandByOrderPluginTest
 * Add your own group annotations below this line
 */
class AddCommandByOrderPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsCommandByOrderPlugin(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Plugin/Oms/Command/TestPaymentCommandByOrder.php');
    }

    /**
     * @return void
     */
    public function testAddsCommandByOrderPluginFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--classNamePrefix' => 'TestPayment',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Plugin/Oms/Command/TestPaymentCommandByOrder.php');
    }
}
