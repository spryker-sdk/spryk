<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Plugin\GlueApplication;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Plugin
 * @group GlueApplication
 * @group AddGlueResourceRelationshipPluginTest
 * Add your own group annotations below this line
 */
class AddGlueResourceRelationshipPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueResourceRelationshipPlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--relationshipParameter' => 'baz',
            '--mode' => 'core',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/FooBarByBazResourceRelationshipPlugin.php');
        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Expander/FooBarByBazExpanderInterface.php');
        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Expander/FooBarByBazExpander.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceRelationshipPluginOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--relationshipParameter' => 'baz',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/FooBarByBazResourceRelationshipPlugin.php');
        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Expander/FooBarByBazExpanderInterface.php');
        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Expander/FooBarByBazExpander.php');
    }
}
