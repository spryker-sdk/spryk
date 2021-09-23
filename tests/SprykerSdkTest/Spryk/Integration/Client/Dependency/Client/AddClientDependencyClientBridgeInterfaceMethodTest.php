<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Client\Dependency\Client;

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
 * @group DependencyClient
 * @group AddClientDependencyClientBridgeInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddClientDependencyClientBridgeInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @skip
     *
     * @return void
     */
    public function testAddsClientDependencyClientInterfaceMethods(): void
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
                'methodWithoutDocBlockReturnType',
                'methodWithMultipleReturn',
                'methodWithMultipleReturnAndNullable',
                'methodWithNullableReturn',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::CLIENT_CLIENT_BRIDGE_INTERFACE, 'methodWithNullableReturn');
    }

    /**
     * @return void
     */
    public function testAddClientDependencyClientInterfaceMethodFailsOnProjectLayer(): void
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
