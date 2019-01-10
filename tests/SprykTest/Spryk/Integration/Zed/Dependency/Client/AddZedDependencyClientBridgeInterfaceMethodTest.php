<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Dependency\Client;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Client
 * @group AddZedDependencyClientBridgeInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddZedDependencyClientBridgeInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedDependencyClientInterfaceMethods(): void
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
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::ZED_CLIENT_BRIDGE_INTERFACE, 'methodWithNullableReturn');
    }
}