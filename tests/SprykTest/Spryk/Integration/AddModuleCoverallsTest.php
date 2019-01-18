<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Exception\SprykWrongDevelopmentLayerException;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddModuleCoverallsTest
 * Add your own group annotations below this line
 */
class AddModuleCoverallsTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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
