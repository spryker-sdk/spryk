<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group AddGlueDependencyProviderTest
 * Add your own group annotations below this line
 */
class AddGlueGetResourceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddGlueGetResourceWillAddResourceRoutePluginAndResource(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--clientModule' => 'ZipZap',
            '--clientMethod' => 'methodWithTransferInputAndTransferOutput',
            '--mode' => 'core',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/FooBarsResourceRoutePlugin.php');
    }

    /**
     * @return void
     */
    public function testAddGlueGetResourceWillAddResourceRoutePluginAndResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--clientModule' => 'ZipZap',
            '--clientMethod' => 'methodWithTransferInputAndTransferOutput',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/FooBarsResourceRoutePlugin.php');
    }
}
