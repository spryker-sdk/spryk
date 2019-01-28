<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Client
 * @group AddYvesDependencyClientDependencyProviderConstantTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyClientDependencyProviderConstantTest extends Unit
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
            ClassName::YVES_DEPENDENCY_PROVIDER,
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
            ClassName::PROJECT_YVES_DEPENDENCY_PROVIDER,
            'CLIENT_ZIP_ZAP',
            'zip zap client',
            'public'
        );
    }
}
