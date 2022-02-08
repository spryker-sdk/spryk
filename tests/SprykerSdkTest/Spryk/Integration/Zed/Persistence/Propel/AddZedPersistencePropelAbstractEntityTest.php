<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Persistence\Propel;

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

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/AbstractSpyFooBar.php');
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

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Persistence/Propel/AbstractSpyFooBar.php',
        );
    }
}
