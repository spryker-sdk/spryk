<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group AddGlueDeleteResourceTest
 * Add your own group annotations below this line
 */
class AddGlueDeleteResourceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddGlueDeleteResourceWillAddResourceRoutePluginAndResource(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--modelName' => 'FooBar',
            '--mode' => 'core',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/FooBarsResourceRoutePlugin.php');
        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/FooBarsResource.php');
    }

    /**
     * @return void
     */
    public function testAddGlueDeleteResourceWillAddResourceRoutePluginAndResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--modelName' => 'FooBar',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/FooBarsResourceRoutePlugin.php');
        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'FooBarsResource.php');
    }
}
