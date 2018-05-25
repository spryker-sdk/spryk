<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Client\FooBar\FooBarClientInterface;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddClientInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddClientInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToClient(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod(FooBarClientInterface::class, 'addSomething');
    }
}
