<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Persistence\Propel;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Persistence
 * @group Propel
 * @group AddZedPersistencePropelAbstractEntityTest
 * Add your own group annotations below this line
 */
class AddZedPersistencePropelAbstractEntityTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedPersistenceAbstractEntityFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/AbstractSpyFooBar.php');
    }

    /**
     * @return void
     */
    public function testAddsZedPersistenceAbstractEntityFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
            '--mode' => 'project',
        ]);

        static::assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Persistence/Propel/AbstractSpyFooBar.php'
        );
    }
}
