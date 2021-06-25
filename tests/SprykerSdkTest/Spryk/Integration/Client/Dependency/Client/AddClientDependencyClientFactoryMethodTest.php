<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Client\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Client
 * @group Dependency
 * @group DependencyClient
 * @group AddClientDependencyClientFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddClientDependencyClientFactoryMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsClientDependencyClientDependencyMethodToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->tester->assertClassHasMethod(ClassName::CLIENT_FACTORY, 'getZipZapClient');
    }

    /**
     * @return void
     */
    public function testAddsClientDependencyClientDependencyMethodToBusinessFactoryOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_CLIENT_FACTORY, 'getZipZapClient');
    }
}
