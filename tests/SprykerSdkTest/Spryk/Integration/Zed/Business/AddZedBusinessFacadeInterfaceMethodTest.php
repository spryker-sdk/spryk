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
            '--facadeMethod' => 'addSomething',
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
            '--facadeMethod' => 'addSomething',
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
     * @group testAddsCommentFacadeInterface
     *
     * @return void
     */
    public function testAddsCommentFacadeInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--facadeMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- First specification line.',
                '- Second specification line.',
            ],
        ]);

        $pathToFacadeInterface = $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/FooBarFacadeInterface.php';
        $facadeInterfaceContent = file_get_contents($pathToFacadeInterface);
        $facadeInterfaceContent = ($facadeInterfaceContent) ?: '';

        $this->assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        $this->assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        $this->assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }

    /**
     * @return void
     */
    public function testAddsCommentFacadeInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--facadeMethod' => 'addSomething',
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

        $this->assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        $this->assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        $this->assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }
}
