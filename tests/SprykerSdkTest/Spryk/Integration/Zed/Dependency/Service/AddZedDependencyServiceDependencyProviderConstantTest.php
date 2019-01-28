<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Service;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Service
 * @group AddZedDependencyServiceDependencyProviderConstantTest
 * Add your own group annotations below this line
 */
class AddZedDependencyServiceDependencyProviderConstantTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDependencyServiceConstantToDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => 'SERVICE_ZIP_ZAP',
            '--value' => 'zip zap service',
            '--visibility' => 'public',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::ZED_DEPENDENCY_PROVIDER,
            'SERVICE_ZIP_ZAP',
            'zip zap service',
            'public'
        );
    }

    /**
     * @return void
     */
    public function testAddsDependencyServiceConstantToDependencyProviderOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => 'SERVICE_ZIP_ZAP',
            '--value' => 'zip zap service',
            '--visibility' => 'public',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::PROJECT_ZED_DEPENDENCY_PROVIDER,
            'SERVICE_ZIP_ZAP',
            'zip zap service',
            'public'
        );
    }
}
