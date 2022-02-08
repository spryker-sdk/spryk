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
 * @group AddGlueFormatResponseHeadersPluginTest
 * Add your own group annotations below this line
 */
class AddGlueFormatResponseHeadersPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsFormatResponseHeadersPlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--modelName' => 'BazQux',
            '--mode' => 'core',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/BazQuxFormatResponseHeadersPlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsFormatResponseHeadersPluginOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--modelName' => 'BazQux',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/BazQuxFormatResponseHeadersPlugin.php',
        );
    }
}
