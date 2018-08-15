<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedPersistenceRepositoryInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddZedPersistenceRepositoryInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedPersistenceRepositoryInterfaceMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'doSomething',
            '--input' => 'string $fooBar',
            '--output' => 'array',
        ]);

        $this->tester->assertClassHasMethod(ClassName::REPOSITORY_INTERFACE, 'doSomething');
    }
}
