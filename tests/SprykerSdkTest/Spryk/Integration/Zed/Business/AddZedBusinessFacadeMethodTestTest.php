<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Business;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Business
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
            '--facadeMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE_TEST, 'testAddSomething');
    }

    /**
     * @return void
     */
    public function testAddsTestMethodToFacadeTestOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--facadeMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_FACADE_TEST, 'testAddSomething');
    }
}
