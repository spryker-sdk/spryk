<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Client
 * @group AddClientConfigMethodTest
 * Add your own group annotations below this line
 */
class AddClientConfigMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsClientConfigMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
        ]);

        $this->tester->assertClassHasMethod(ClassName::CLIENT_CONFIG, 'getConfigValue');
    }

    /**
     * @return void
     */
    public function testAddsClientConfigMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_CLIENT_CONFIG, 'getConfigValue');
    }
}
