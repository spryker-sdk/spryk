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
 * @group AddYvesThemeTest
 * Add your own group annotations below this line
 */
class AddYvesThemeTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testYvesThemeDirectory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--theme' => 'mobile',
        ]);

        $this->assertDirectoryExists(
            $this->tester->getSprykerShopModuleDirectory()
            . 'src/SprykerShop/Yves/FooBar/Theme/mobile',
        );
    }

    /**
     * @return void
     */
    public function testYvesThemeDirectoryOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--theme' => 'mobile',
            '--mode' => 'project',
        ]);

        $this->assertDirectoryExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Theme/mobile',
        );
    }
}
