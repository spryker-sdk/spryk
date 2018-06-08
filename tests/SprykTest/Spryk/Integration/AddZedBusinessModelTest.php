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
 * @group AddZedBusinessModelTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessModel(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--constructorArguments' => '\Spryker\Zed\FooBar\Business\Foo\Zip $zip, \Spryker\Zed\FooBar\Business\Foo\Zap $zap',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/Foo/Bar.php');
    }

    /**
     * @return void
     */
    public function testAddsConstructor(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--constructorArguments' => '\Spryker\Zed\FooBar\Business\Foo\Zip $zip, \Spryker\Zed\FooBar\Business\Foo\Zap $zap',
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Foo\Bar', '__construct');
    }

    /**
     * @return void
     */
    public function testAddsMethodToZedBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar');
    }

    /**
     * @return void
     */
    public function testInjectsDependenciesInBusinessFactoryMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Bar',
            '--subDirectory' => 'Foo',
            '--constructorArguments' => '\Spryker\Zed\FooBar\Business\Foo\Zip $zip, \Spryker\Zed\FooBar\Business\Foo\Zap $zap',
            '--dependencyMethods' => [
                'createZip',
                'createZap',
            ],
        ]);

        $expectedBody = 'return new \Spryker\Zed\FooBar\Business\Foo\Bar($this->createZip(), $this->createZap());';
        $this->tester->assertMethodBody('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createBar', $expectedBody);
    }
}
