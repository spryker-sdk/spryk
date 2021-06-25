<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Business;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Business
 * @group AddZedBusinessFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFactoryMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Foo',
            '--className' => 'Bar',
            '--output' => 'Spryker\Zed\FooBar\Business\Foo\Bar',
        ]);
        $expectedBody = 'return new \Spryker\Zed\FooBar\Business\Foo\Bar();';
        $this->tester->assertMethodBody('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }

    /**
     * @return void
     */
    public function testAddsMethodToBusinessFactoryOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Foo',
            '--className' => 'Bar',
            '--output' => 'Pyz\Zed\FooBar\Business\Foo\Bar',
            '--mode' => 'project',
        ]);
        $expectedBody = 'return new \Pyz\Zed\FooBar\Business\Foo\Bar();';
        $this->tester->assertMethodBody('Pyz\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }

    /**
     * @return void
     */
    public function testAddsMethodWithBodyToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Foo',
            '--className' => 'Bar',
            '--dependencyMethods' => [
                'createZip',
                'createZap',
            ],
            '--output' => 'Spryker\Zed\FooBar\Business\Foo\Bar',
        ]);

        $expectedBody = 'return new \Spryker\Zed\FooBar\Business\Foo\Bar($this->createZip(), $this->createZap());';
        $this->tester->assertMethodBody('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }

    /**
     * @return void
     */
    public function testAddsMethodWithBodyToBusinessFactoryOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Foo',
            '--className' => 'Bar',
            '--dependencyMethods' => [
                'createZip',
                'createZap',
            ],
            '--output' => 'Pyz\Zed\FooBar\Business\Foo\Bar',
            '--mode' => 'project',
        ]);

        $expectedBody = 'return new \Pyz\Zed\FooBar\Business\Foo\Bar($this->createZip(), $this->createZap());';
        $this->tester->assertMethodBody('Pyz\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }
}
