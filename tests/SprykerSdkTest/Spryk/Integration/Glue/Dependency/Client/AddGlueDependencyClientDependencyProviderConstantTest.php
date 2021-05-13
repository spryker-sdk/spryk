<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Dependency
 * @group Client
 * @group AddZedDependencyClientDependencyProviderConstantTest
 * Add your own group annotations below this line
 */
class AddGlueDependencyClientDependencyProviderConstantTest extends Unit
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
            '--value' => 'CLIENT_ZIP_ZAP',
            '--visibility' => 'public',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::GLUE_DEPENDENCY_PROVIDER,
            'CLIENT_ZIP_ZAP',
            'CLIENT_ZIP_ZAP',
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
            '--value' => 'CLIENT_ZIP_ZAP',
            '--visibility' => 'public',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::PROJECT_GLUE_DEPENDENCY_PROVIDER,
            'CLIENT_ZIP_ZAP',
            'CLIENT_ZIP_ZAP',
            'public'
        );
    }
}
