<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddZedBusinessModelInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessModelInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Spryker\Zed\FooBar\Business\Foo\Bar',
            '--method' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Foo\BarInterface', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsMethodToBusinessModelInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Pyz\Zed\FooBar\Business\Foo\Bar',
            '--method' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(
            'Pyz\Zed\FooBar\Business\Foo\BarInterface',
            'addSomething'
        );
    }
}
