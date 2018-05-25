<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddCoverallsTest
 * Add your own group annotations below this line
 */
class AddCoverallsTest extends Unit
{
    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsCoverallsFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--repositoryToken' => 'uzf78t67832fe76923f764f3249f329f)&/vuzf76&/R',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . '.coveralls.yml');
    }
}
