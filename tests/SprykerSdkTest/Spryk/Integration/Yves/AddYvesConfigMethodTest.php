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
            '--configMethod' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
        ]);

        $this->tester->assertClassHasMethod(ClassName::YVES_CONFIG, 'getConfigValue');
    }

    /**
     * @return void
     */
    public function testAddsYvesConfigMethodOnProjectLevel(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--configMethod' => 'getConfigValue',
            '--input' => 'string $foo',
            '--output' => 'string',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CONFIG, 'getConfigValue');
    }
}
