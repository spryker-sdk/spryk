<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group DomainEntity
 * @group AddZedDomainEntityMethodTest
 * Add your own group annotations below this line
 */
class AddZedDomainEntityMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddZedDomainEntityMethod(): void
    {
        $this->tester->run($this, [
            '--mode' => 'core',
            '--module' => 'FooBar',
            '--subDirectory' => 'Entity',
            '--className' => 'FooBarEntity',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod('\Spryker\Zed\FooBar\Business\Entity\FooBarEntityInterface', 'addSomething');
    }

    /**
     * @return void
     */
    public function testAddZedDomainEntityMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--mode' => 'project',
            '--module' => 'FooBar',
            '--subDirectory' => 'Entity',
            '--className' => 'FooBarEntity',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod('\Pyz\Zed\FooBar\Business\Entity\FooBarEntityInterface', 'addSomething');
    }
}
