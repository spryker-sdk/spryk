<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Plugin\GlueApplication;

use Codeception\Test\Unit;

class AddGlueResourceRelationshipPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueResource(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--relationshipParameter' => 'baz',
            '--mode' => 'core',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/FooBarByBazResourceRelationshipPlugin.php');
        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Expander/FooBarByBazExpanderInterface.php');
        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Processor/Expander/FooBarByBazExpander.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--relationshipParameter' => 'baz',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/FooBarByBazResourceRelationshipPlugin.php');
        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Expander/FooBarByBazExpanderInterface.php');
        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Processor/Expander/FooBarByBazExpander.php');
    }
}
