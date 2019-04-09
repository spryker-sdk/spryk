<?php

namespace SprykerSdkTest\Spryk\Integration\Glue\GlueStorefront;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group GlueStorefront
 * @group AddGlueStorefrontRestResourceRelationshipPluginTest
 * Add your own group annotations below this line
 */
class AddGlueStorefrontRestResourceRelationshipPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueStorefrontRestResourcePlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--pluginName' => 'FooBarResourceRelationshipsPlugin',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueStorefront/FooBarResourceRelationshipsPlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueStorefrontRestResourcePluginOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
            '--pluginName' => 'FooBarResourceRelationshipsPlugin',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueStorefront/FooBarResourceRelationshipsPlugin.php');
    }
}