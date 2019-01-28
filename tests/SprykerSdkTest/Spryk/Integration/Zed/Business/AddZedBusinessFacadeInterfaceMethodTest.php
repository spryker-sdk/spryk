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
 * @group Facade
 * @group AddZedBusinessFacadeInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFacadeInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToFacadeInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- First specification line.',
                '- Second specification line.',
            ],
        ]);

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarFacadeInterface', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsMethodToFacadeInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- First specification line.',
                '- Second specification line.',
            ],
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod('Pyz\Zed\FooBar\Business\FooBarFacadeInterface', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsCommentFacadeInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- First specification line.',
                '- Second specification line.',
            ],
        ]);

        $pathToFacadeInterface = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/FooBarFacadeInterface.php';
        $facadeInterfaceContent = file_get_contents($pathToFacadeInterface);
        $facadeInterfaceContent = ($facadeInterfaceContent) ?: '';

        static::assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        static::assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        static::assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }

    /**
     * @return void
     */
    public function testAddsCommentFacadeInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- First specification line.',
                '- Second specification line.',
            ],
            '--mode' => 'project',
        ]);

        $pathToFacadeInterface = $this->tester->getProjectModuleDirectory()
            . 'Business/FooBarFacadeInterface.php';
        $facadeInterfaceContent = file_get_contents($pathToFacadeInterface);
        $facadeInterfaceContent = ($facadeInterfaceContent) ?: '';

        static::assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        static::assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        static::assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }
}
