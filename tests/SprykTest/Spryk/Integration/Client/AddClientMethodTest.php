<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Client;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Client
 * @group AddClientMethodTest
 * Add your own group annotations below this line
 */
class AddClientMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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

        $this->tester->assertClassHasMethod(ClassName::CLIENT, 'addSomething');
    }
}
