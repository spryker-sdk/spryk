<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Client\Dependency\Service;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Client
 * @group Dependency
 * @group Service
 * @group AddClientDependencyServiceBridgeMethodTest
 * Add your own group annotations below this line
 */
class AddClientDependencyServiceBridgeMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @skip Skipped for further investigation prioritisation and fix.
     *
     * @return void
     */
    public function testAddsClientDependencyServiceBridgeMethods(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
                'methodWithArrayArgument',
                'methodReturnsVoid',
                'methodWithTransferInputAndTransferOutput',
                'methodWithDefaultNull',
                'methodWithDefaultArray',
                'methodWithoutMethodReturnType',
                'methodWithoutDocBlockReturnType',
                'methodWithMultipleReturn',
                'methodWithMultipleReturnAndNullable',
                'methodWithNullableReturn',
            ],
        ]);

        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithoutMethodReturnType');
        $this->tester->assertClassNotContains(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithoutMethodReturnType(): void');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithNullableReturn');
    }

    /**
     * @return void
     */
    public function testAddsClientDependencyServiceBridgeMethodOnlyOnce(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithStringArgument');

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::CLIENT_SERVICE_BRIDGE, 'methodWithStringArgument');
    }

    /**
     * @return void
     */
    public function testAddClientDependencyServiceBridgeMethodThrowsExceptionFailsOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
            '--mode' => 'project',
        ]);
    }
}
