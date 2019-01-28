<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddModuleGitignoreTest
 * Add your own group annotations below this line
 */
class AddModuleGitignoreTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGitignoreFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . '.gitignore');
    }

    /**
     * @return void
     */
    public function testAddsGitignoreFileOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . '.gitignore');
    }
}
