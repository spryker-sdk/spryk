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
 * @group Glue
 * @group Dependency
 * @group Client
 * @group AddZedDependencyClientDependencyProviderMethodTest
 * Add your own group annotations below this line
 */
class AddGlueDependencyClientDependencyProviderMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDependencyClientMethodToDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->tester->assertClassHasMethod(ClassName::GLUE_DEPENDENCY_PROVIDER, 'addZipZapClient');
    }

    /**
     * @return void
     */
    public function testAddsDependencyClientMethodToDependencyProviderOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_GLUE_DEPENDENCY_PROVIDER, 'addZipZapClient');
    }
}
