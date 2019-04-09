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
 * @group AddGlueStorefrontDependencyProviderTest
 * Add your own group annotations below this line
 */
class AddGlueStorefrontDependencyProviderTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueStorefrontDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/FooBarDependencyProvider.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueStorefrontDependencyProviderOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'FooBarDependencyProvider.php');
    }
}
