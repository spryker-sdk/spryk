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

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/Schema/spy_foo_bar.schema.xml');
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

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Persistence/Propel/Schema/spy_foo_bar.schema.xml',
        );
    }
}
