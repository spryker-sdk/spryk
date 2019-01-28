<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Persistence\Propel\Schema;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Persistence
 * @group Propel
 * @group Schema
 * @group AddZedPersistencePropelSchemaTest
 * Add your own group annotations below this line
 */
class AddZedPersistencePropelSchemaTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedPersistencePropelSchemaFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/Schema/spy_foo_bar.schema.xml');
    }

    /**
     * @return void
     */
    public function testAddsZedPersistencePropelSchemaFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Persistence/Propel/Schema/spy_foo_bar.schema.xml'
        );
    }
}
