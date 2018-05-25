<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Client\FooBar\FooBarClient;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddClientMethodTest
 * Add your own group annotations below this line
 */
class AddClientMethodTest extends Unit
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

        $this->tester->assertClassHasMethod(FooBarClient::class, 'addSomething');
    }
}
