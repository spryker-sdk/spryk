<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Plugin\GlueApplication;

use Codeception\Test\Unit;

class AddFormatRequestPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddFormatResponseDataPlugin(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--modelName' => 'BazQux',
            '--mode' => 'core',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Plugin/GlueApplication/BazQuxFormatRequestPlugin.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--modelName' => 'BazQux',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Plugin/GlueApplication/BazQuxFormatRequestPlugin.php');
    }
}
