<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddModuleChangelogTest
 * Add your own group annotations below this line
 */
class AddClass extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddClassMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBar',
            '--implementerInterfaceName' => 'FooBar',
            '--expanderClassName' => 'FooBar',
            '--subDirectory' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'CHANGELOG.md');
    }

    /**
     * @return void
     */
    public function testAddClassMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
            '--className' => 'FooBar',
            '--implementerInterfaceName' => 'FooBar',
            '--expanderClassName' => 'FooBar',
            '--subDirectory' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'CHANGELOG.md');
    }
}
