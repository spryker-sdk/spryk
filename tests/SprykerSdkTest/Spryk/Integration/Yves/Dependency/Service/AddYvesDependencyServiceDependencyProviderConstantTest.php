<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Service;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Service
 * @group AddYvesDependencyServiceDependencyProviderConstantTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyServiceDependencyProviderConstantTest extends Unit
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
            ClassName::YVES_DEPENDENCY_PROVIDER,
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
            ClassName::PROJECT_YVES_DEPENDENCY_PROVIDER,
            'SERVICE_ZIP_ZAP',
            'zip zap service',
            'public'
        );
    }
}
