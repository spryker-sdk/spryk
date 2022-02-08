<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group AddYvesWidgetTest
 * Add your own group annotations below this line
 */
class AddYvesWidgetTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesWidgetFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--widget' => 'ZipZap',
        ]);

        $this->assertFileExists($this->tester->getSprykerShopModuleDirectory() . 'src/SprykerShop/Yves/FooBar/Widget/ZipZapWidget.php');
    }

    /**
     * @return void
     */
    public function testAddsYvesWidgetFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--widget' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Widget/ZipZapWidget.php',
        );
    }
}
