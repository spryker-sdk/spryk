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
 * @group AddGlueStorefrontRestResourcePluginTest
 * Add your own group annotations below this line
 */
class AddGlueStorefrontRestResourcePluginTest extends Unit
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
            '--pluginName' => 'FooBarResourcePlugin',
            '--className' => 'FooBarController',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueStorefront/FooBarResourcePlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueStorefrontRestResourcePluginOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
            '--pluginName' => 'FooBarResourcePlugin',
            '--className' => 'FooBarController',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueStorefront/FooBarResourcePlugin.php');
    }
}