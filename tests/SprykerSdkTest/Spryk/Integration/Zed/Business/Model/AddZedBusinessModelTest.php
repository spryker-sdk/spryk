<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Business\Model;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Business
 * @group Model
 * @group AddZedBusinessModelTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testInjectsDependenciesInBusinessFactoryMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--constructorArguments' => [
                '\Spryker\Zed\FooBar\Business\Foo\Zip $zip',
                '\Spryker\Zed\FooBar\Business\Foo\Zap $zap',
            ],
            '--dependencyMethods' => [
                'createZip',
                'createZap',
            ],
        ]);

        $expectedBody = 'return new \Spryker\Zed\FooBar\Business\Foo\Bar($this->createZip(), $this->createZap());';
        $this->tester->assertMethodBody('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }

    /**
     * @return void
     */
    public function testInjectsDependenciesInBusinessFactoryMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--constructorArguments' => [
                '\Pyz\Zed\FooBar\Business\Foo\Zip $zip',
                '\Pyz\Zed\FooBar\Business\Foo\Zap $zap',
            ],
            '--dependencyMethods' => [
                'createZip',
                'createZap',
            ],
            '--mode' => 'project',
        ]);

        $expectedBody = 'return new \Pyz\Zed\FooBar\Business\Foo\Bar($this->createZip(), $this->createZap());';
        $this->tester->assertMethodBody('Pyz\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }
}
