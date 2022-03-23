<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Plugin;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Plugin
 * @group AddZedDependencyPluginsTest
 * Add your own group annotations below this line
 */
class AddZedDependencyPluginsTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDependencyConstantAndMethodsToDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--type' => 'zipZap',
            '--output' => '\\Spryker\\Zed\\FooBarExtension\\Dependency\\FooBarPluginInterface[]',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::ZED_DEPENDENCY_PROVIDER,
            'PLUGINS_ZIP_ZAP',
            'PLUGINS_ZIP_ZAP',
            'public',
        );

        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'provideBusinessLayerDependencies');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapPlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapPlugins');
    }
}
