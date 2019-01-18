<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Yves\Dependency\Client;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
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
     * @var \SprykTest\SprykIntegrationTester
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
