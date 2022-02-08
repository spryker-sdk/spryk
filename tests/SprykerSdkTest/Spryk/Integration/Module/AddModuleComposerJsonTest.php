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
 * @group AddModuleComposerJsonTest
 * Add your own group annotations below this line
 */
class AddModuleComposerJsonTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsComposerJsonFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'composer.json');
    }

    /**
     * @return void
     */
    public function testAddModuleComposerJsonFailsOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);
    }
}
