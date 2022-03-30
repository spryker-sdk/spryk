<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group DomainEntity
 * @group AddZedDomainEntityTest
 * Add your own group annotations below this line
 */
class AddZedDomainEntityTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddZedDomainEntity(): void
    {
        $this->tester->run($this, [
            '--mode' => 'core',
            '--module' => 'FooBar',
            '--subDirectory' => 'Entity',
            '--className' => 'FooBarEntity',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/Entity/FooBarEntity.php');
        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/Entity/FooBarEntityInterface.php');
    }

    /**
     * @return void
     */
    public function testAddZedDomainEntityOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--mode' => 'project',
            '--module' => 'FooBar',
            '--subDirectory' => 'Entity',
            '--className' => 'FooBarEntity',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Business/Entity/FooBarEntity.php');
        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Business/Entity/FooBarEntityInterface.php');
    }
}
