<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Module;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Module
 * @group AddModuleContributingTest
 * Add your own group annotations below this line
 */
class AddModuleContributingTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsContributingFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'CONTRIBUTING.md');
    }

    /**
     * @return void
     */
    public function testAddModuleContributingFailsOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);
    }
}
