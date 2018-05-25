<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Zed\FooBar\FooBarConfig;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedConfigMethodTest
 * Add your own group annotations below this line
 */
class AddZedConfigMethodTest extends Unit
{
    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedConfigMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
        ]);

        $this->tester->assertClassHasMethod(FooBarConfig::class, 'getConfigValue');
    }
}
