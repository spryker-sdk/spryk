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
 * @group AddYvesConfigMethodTest
 * Add your own group annotations below this line
 */
class AddYvesConfigMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesConfigMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
        ]);

        $this->tester->assertClassHasMethod(ClassName::YVES_CONFIG, 'getConfigValue');
    }

    /**
     * @return void
     */
    public function testAddsYvesConfigMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CONFIG, 'getConfigValue');
    }
}
