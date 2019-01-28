<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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

        static::assertFileExists($this->tester->getModuleDirectory() . '.coveralls.yml');
    }

    /**
     * @return void
     */
    public function testAddsCoverallsFileOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
            '--repositoryToken' => 'uzf78t67832fe76923f764f3249f329f)&/vuzf76&/R',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . '.coveralls.yml');
    }
}
