<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
            '--configMethod' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
        ]);

        $this->tester->assertClassHasMethod(ClassName::CLIENT_CONFIG, 'getConfigValue');
    }

    /**
     * @return void
     */
//    public function testAddsClientConfigMethodOnProjectLayer(): void
//    {
//        $this->tester->run($this, [
//            '--module' => 'FooBar',
//            '--configMethod' => 'getConfigValue',
//            '--input' => 'string $foo',
//            '--output' => 'string',
//            '--mode' => 'project',
//        ]);
//
//        $this->tester->assertClassHasMethod(ClassName::PROJECT_CLIENT_CONFIG, 'getConfigValue');
//    }
}
