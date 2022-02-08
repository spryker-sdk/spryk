<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Persistence\Propel\Schema;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Persistence
 * @group Propel
 * @group Schema
 * @group AddZedPersistencePropelSchemaTableTest
 * Add your own group annotations below this line
 */
class AddZedPersistencePropelSchemaTableTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedPersistencePropelSchemaTable(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
        ]);

        $this->tester->assertTableCount(1, $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/Schema/spy_foo_bar.schema.xml', 'spy_foo_bar');
    }

    /**
     * @return void
     */
    public function testAddsZedPersistencePropelSchemaTableOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
            '--mode' => 'project',
        ]);

        $this->tester->assertTableCount(
            1,
            $this->tester->getProjectModuleDirectory() . 'Persistence/Propel/Schema/spy_foo_bar.schema.xml',
            'spy_foo_bar',
        );
    }

    /**
     * @return void
     */
    public function testAddsZedPersistencePropelSchemaTableOnlyOnce(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
        ]);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
        ]);

        $this->tester->assertTableCount(1, $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/Schema/spy_foo_bar.schema.xml', 'spy_foo_bar');
    }

    /**
     * @return void
     */
    public function testAddsZedPersistencePropelSchemaTableOnlyOnceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
            '--mode' => 'project',
        ]);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--targetModule' => 'FooBar',
            '--tableName' => 'spy_foo_bar',
            '--mode' => 'project',
        ]);

        $this->tester->assertTableCount(
            1,
            $this->tester->getProjectModuleDirectory() . 'Persistence/Propel/Schema/spy_foo_bar.schema.xml',
            'spy_foo_bar',
        );
    }
}
