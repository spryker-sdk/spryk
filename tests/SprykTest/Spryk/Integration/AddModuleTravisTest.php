<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddModuleTravisTest
 * Add your own group annotations below this line
 */
class AddModuleTravisTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsTravisFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . '.travis.yml');
    }
}
