<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Persistence;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Persistence
 * @group AddZedPersistenceEntityManagerMethodTest
 * Add your own group annotations below this line
 */
class AddZedPersistenceEntityManagerMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedPersistenceEntitityManagerMethodMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--entityManagerMethod' => 'doSomething',
            '--input' => 'string $fooBar',
            '--output' => 'array',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_ENTITY_MANAGER, 'doSomething');
    }

    /**
     * @return void
     */
    public function testAddsZedPersistenceEntityManagerMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--entityManagerMethod' => 'doSomething',
            '--input' => 'string $fooBar',
            '--output' => 'array',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_ENTITY_MANAGER, 'doSomething');
    }
}
