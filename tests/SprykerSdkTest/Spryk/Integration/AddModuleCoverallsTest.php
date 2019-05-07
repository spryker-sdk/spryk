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
 * @group AddModuleCoverallsTest
 * Add your own group annotations below this line
 */
class AddModuleCoverallsTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsCoverallsFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--repositoryToken' => 'uzf78t67832fe76923f764f3249f329f)&/vuzf76&/R',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . '.coveralls.yml');
    }

    /**
     * @return void
     */
    public function testTryToAddCoverallsFileOnProjectLevelThrowsException(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--repositoryToken' => 'uzf78t67832fe76923f764f3249f329f)&/vuzf76&/R',
            '--mode' => 'project',
        ]);
    }
}
