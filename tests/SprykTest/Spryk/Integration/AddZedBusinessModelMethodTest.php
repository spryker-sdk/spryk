<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Zed\FooBar\Business\FooBarFacade;
use Spryker\Zed\FooBar\Business\FooBarFacadeInterface;
use Spryker\Zed\FooBar\Business\Model\FooBar;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedBusinessModelMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessModel(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod(FooBar::class, 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsFacadeMethodWhenSubSprykIsIncluded(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--include-optional' => [
                'AddZedBusinessFacadeMethod',
            ],
        ]);

        $this->tester->assertClassHasMethod(FooBarFacade::class, 'addSomething');
        $this->tester->assertClassHasMethod(FooBarFacadeInterface::class, 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsFacadeMethodWithDifferentName(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
            '--method' => 'addSomething',
            '--facadeMethod' => 'addSomethingDifferent',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--include-optional' => [
                'AddZedBusinessFacadeMethod',
            ],
        ]);

        $this->tester->assertClassHasMethod(FooBarFacade::class, 'addSomethingDifferent');
        $this->tester->assertClassHasMethod(FooBarFacadeInterface::class, 'addSomethingDifferent');
    }
}
