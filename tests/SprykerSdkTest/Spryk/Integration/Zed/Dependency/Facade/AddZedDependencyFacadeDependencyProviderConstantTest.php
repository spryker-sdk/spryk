<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Facade;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Facade
 * @group AddZedDependencyFacadeDependencyProviderConstantTest
 * Add your own group annotations below this line
 */
class AddZedDependencyFacadeDependencyProviderConstantTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDependencyFacadeConstantToDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => 'FACADE_ZIP_ZAP',
            '--value' => 'zip zap facade',
            '--visibility' => 'public',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::ZED_DEPENDENCY_PROVIDER,
            'FACADE_ZIP_ZAP',
            'zip zap facade',
            'public'
        );
    }

    /**
     * @return void
     */
    public function testAddsDependencyFacadeConstantToDependencyProviderOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--name' => 'FACADE_ZIP_ZAP',
            '--value' => 'zip zap facade',
            '--visibility' => 'public',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::PROJECT_ZED_DEPENDENCY_PROVIDER,
            'FACADE_ZIP_ZAP',
            'zip zap facade',
            'public'
        );
    }
}
