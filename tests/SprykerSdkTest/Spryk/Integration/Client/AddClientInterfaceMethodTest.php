<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Client
 * @group AddClientInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddClientInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToClient(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--clientMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod(ClassName::CLIENT_INTERFACE, 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsMethodToClientOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--clientMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_CLIENT_INTERFACE, 'addSomething');
    }
}
