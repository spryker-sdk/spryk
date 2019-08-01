<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Plugin\GlueApplication;

use Codeception\Test\Unit;

class AddRestRequestValidatorPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsRestRequestValidatorPlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--modelName' => 'BazQux',
            '--mode' => 'core',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/BazQuxRestRequestValidatorPlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsRestRequestValidatorPluginOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--modelName' => 'BazQux',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/BazQuxRestRequestValidatorPlugin.php');
    }
}
