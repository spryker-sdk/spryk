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
 * @group Facade
 * @group AddZedBusinessFacadeMethodTestTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFacadeMethodTestTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsTestMethodToFacadeTest(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE_TEST, 'testAddSomething_add_test_info');
    }

    /**
     * @return void
     */
    public function testAddsTestMethodToFacadeTestOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--method' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_FACADE_TEST, 'testAddSomething_add_test_info');
    }
}
