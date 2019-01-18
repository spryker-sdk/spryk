<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Yves\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Client
 * @group AddYvesDependencyClientBridgeInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyClientBridgeInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesDependencyClientInterfaceMethods(): void
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
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithNullableReturn');
    }

    /**
     * @return void
     */
    public function testAddsYvesDependencyClientInterfaceMethodsOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

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
            '--mode' => 'project',
        ]);
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CLIENT_BRIDGE_INTERFACE, 'methodWithNullableReturn');
    }
}
