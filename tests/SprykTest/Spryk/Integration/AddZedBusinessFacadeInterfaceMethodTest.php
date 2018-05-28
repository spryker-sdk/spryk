<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Zed\FooBar\Business\FooBarFacadeInterface;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Facade
 * @group AddZedBusinessFacadeInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFacadeInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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

        $this->tester->assertClassHasMethod(FooBarFacadeInterface::class, 'addSomething');
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

        $this->assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        $this->assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        $this->assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }
}
