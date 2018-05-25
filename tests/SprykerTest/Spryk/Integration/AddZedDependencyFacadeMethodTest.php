<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Zed\FooBar\Dependency\Facade\FooBarToZipZapFacadeBridge;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Facade
 * @group AddZedDependencyFacadeMethodTest
 * Add your own group annotations below this line
 */
class AddZedDependencyFacadeMethodTest extends Unit
{
    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedDependencyFacadeMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--method' => 'doSomething',
            '--input' => 'string $fooBar',
            '--output' => 'array',
        ]);

        $this->tester->assertClassHasMethod(FooBarToZipZapFacadeBridge::class, 'doSomething');
    }
}
