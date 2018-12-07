<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedBusinessFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFactoryMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--moduleName' => 'FooBar',
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
    public function testAddsMethodWithBodyToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--moduleName' => 'FooBar',
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
}
