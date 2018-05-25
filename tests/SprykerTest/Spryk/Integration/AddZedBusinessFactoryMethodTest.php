<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Zed\FooBar\Business\FooBarBusinessFactory;

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
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
            '--output' => 'Spryker\Zed\FooBar\Business\Model\FooBar',
        ]);

        $this->tester->assertClassHasMethod(FooBarBusinessFactory::class, 'createFooBar');
    }
}
