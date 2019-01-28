<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Service;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Service
 * @group AddZedDependencyServiceBridgeMethodTest
 * Add your own group annotations below this line
 */
class AddZedDependencyServiceBridgeMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedDependencyServiceBridgeMethods(): void
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

        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithoutMethodReturnType');
        $this->tester->assertClassNotContains(ClassName::ZED_SERVICE_BRIDGE, 'methodWithoutMethodReturnType(): void');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithNullableReturn');
    }

    /**
     * @return void
     */
    public function testAddsZedDependencyServiceBridgeMethodsOnProjectLayer(): void
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
                'methodWithoutMethodReturnType',
                'methodWithoutDocBlockReturnType',
                'methodWithMultipleReturn',
                'methodWithMultipleReturnAndNullable',
                'methodWithNullableReturn',
            ],
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithoutMethodReturnType');
        $this->tester->assertClassNotContains(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithoutMethodReturnType(): void');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithNullableReturn');
    }

    /**
     * @return void
     */
    public function testAddsZedDependencyServiceBridgeMethodOnlyOnce(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithStringArgument');

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::ZED_SERVICE_BRIDGE, 'methodWithStringArgument');
    }

    /**
     * @return void
     */
    public function testAddsZedDependencyServiceBridgeMethodOnlyOnceOnProjectLayer(): void
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
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithStringArgument');

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
            '--mode' => 'project',
        ]);
        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_SERVICE_BRIDGE, 'methodWithStringArgument');
    }
}
