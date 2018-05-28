<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Yves\FooBar\FooBarConfig;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddYvesConfigMethodTest
 * Add your own group annotations below this line
 */
class AddYvesConfigMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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

        $this->tester->assertClassHasMethod(FooBarConfig::class, 'getConfigValue');
    }
}
