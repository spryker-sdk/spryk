<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Client
 * @group AddZedDependencyClientDependencyProviderConstantTest
 * Add your own group annotations below this line
 */
class AddZedDependencyClientDependencyProviderConstantTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDependencyClientConstantToDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => 'CLIENT_ZIP_ZAP',
            '--value' => 'zip zap client',
            '--visibility' => 'public',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::ZED_DEPENDENCY_PROVIDER,
            'CLIENT_ZIP_ZAP',
            'zip zap client',
            'public'
        );
    }

    /**
     * @return void
     */
    public function testAddsDependencyClientConstantToDependencyProviderOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => 'CLIENT_ZIP_ZAP',
            '--value' => 'zip zap client',
            '--visibility' => 'public',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::PROJECT_ZED_DEPENDENCY_PROVIDER,
            'CLIENT_ZIP_ZAP',
            'zip zap client',
            'public'
        );
    }
}
