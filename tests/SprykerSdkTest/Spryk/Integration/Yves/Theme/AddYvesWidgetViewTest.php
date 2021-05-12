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
 * @group AddYvesWidgetViewTest
 * Add your own group annotations below this line
 */
class AddYvesWidgetViewTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesWidgetViewFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--theme' => 'mobile',
            '--templateName' => 'index',
        ]);

        $this->assertFileExists(
            $this->tester->getModuleDirectory()
            . 'src/Spryker/Yves/FooBar/Theme/mobile/views/index/index.twig'
        );
    }

    /**
     * @return void
     */
    public function testAddsYvesWidgetViewFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--theme' => 'mobile',
            '--templateName' => 'index',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Theme/mobile/views/index/index.twig'
        );
    }
}
