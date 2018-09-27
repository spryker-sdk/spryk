<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Dependency\Service;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
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
     * @var \SprykTest\SprykIntegrationTester
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
}
