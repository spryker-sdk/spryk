<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddZedBusinessModelMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessModel(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Foo\Bar', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsMethodToBusinessModelOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod('Pyz\Zed\FooBar\Business\Foo\Bar', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsFacadeMethodWhenSubSprykIsIncluded(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--include-optional' => [
                'AddZedBusinessFacadeMethod',
            ],
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarFacade', 'addSomething');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarFacadeInterface', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsFacadeMethodWhenSubSprykIsIncludedOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--include-optional' => [
                'AddZedBusinessFacadeMethod',
            ],
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod('Pyz\Zed\FooBar\Business\FooBarFacade', 'addSomething');
        $this->tester->assertClassHasMethod('Pyz\Zed\FooBar\Business\FooBarFacadeInterface', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsFacadeMethodWithDifferentName(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--modelMethod' => 'addSomething',
            '--facadeMethod' => 'addSomethingDifferent',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--include-optional' => [
                'AddZedBusinessFacadeMethod',
            ],
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarFacade', 'addSomethingDifferent');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarFacadeInterface', 'addSomethingDifferent');
    }

    /**
     * @return void
     */
    public function testAddsFacadeMethodWithDifferentNameOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--modelMethod' => 'addSomething',
            '--facadeMethod' => 'addSomethingDifferent',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--include-optional' => [
                'AddZedBusinessFacadeMethod',
            ],
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod('Pyz\Zed\FooBar\Business\FooBarFacade', 'addSomethingDifferent');
        $this->tester->assertClassHasMethod('Pyz\Zed\FooBar\Business\FooBarFacadeInterface', 'addSomethingDifferent');
    }
}
