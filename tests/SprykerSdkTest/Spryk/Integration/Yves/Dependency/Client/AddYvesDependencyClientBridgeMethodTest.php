<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Client
 * @group AddYvesDependencyClientBridgeMethodTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyClientBridgeMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesDependencyClientBridgeMethods(): void
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

        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithStringArgument');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithArrayArgument');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodReturnsVoid');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithTransferInputAndTransferOutput');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithDefaultNull');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithDefaultArray');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithoutMethodReturnType');
        $this->tester->assertClassNotContains(ClassName::YVES_CLIENT_BRIDGE, 'methodWithoutMethodReturnType(): void');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithoutDocBlockReturnType');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithMultipleReturn');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithMultipleReturnAndNullable');
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithNullableReturn');
    }

    /**
     * @return void
     */
    public function testAddsYvesDependencyClientBridgeMethodOnlyOnce(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithStringArgument');

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
        $this->tester->assertClassHasMethod(ClassName::YVES_CLIENT_BRIDGE, 'methodWithStringArgument');
    }

    /**
     * @return void
     */
    public function testAddYvesDependencyClientBridgeMethodFailsOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
            '--methods' => [
                'methodWithStringArgument',
            ],
        ]);
    }
}
