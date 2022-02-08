<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Theme;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Theme
 * @group AddYvesViewTest
 * Add your own group annotations below this line
 */
class AddYvesViewTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesViewFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--theme' => 'mobile',
            '--templateName' => 'index',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerShopModuleDirectory()
            . 'src/SprykerShop/Yves/FooBar/Theme/mobile/views/index/index.twig',
        );
    }

    /**
     * @return void
     */
    public function testAddsYvesViewFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--theme' => 'mobile',
            '--templateName' => 'index',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Theme/mobile/views/index/index.twig',
        );
    }
}
