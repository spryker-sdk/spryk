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
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Facade
 * @group AddZedBusinessFacadeMethodTest
 * Add your own group annotations below this line
 */
class AddZedBusinessFacadeMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethodToFacade(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--facadeMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- Line one.',
                '- Line two.',
            ],
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE, 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddsMethodToFacadeOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--facadeMethod' => 'addSomething',
            '--input' => 'string $something',
            '--output' => 'bool',
            '--specification' => [
                '- Line one.',
                '- Line two.',
            ],
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_FACADE, 'addSomething');
    }
}
