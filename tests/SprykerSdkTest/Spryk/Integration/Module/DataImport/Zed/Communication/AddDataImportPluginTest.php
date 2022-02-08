<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Module\DataImport\Zed\Communication;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Module
 * @group DataImport
 * @group Zed
 * @group Communication
 * @group AddDataImportPluginTest
 * Add your own group annotations below this line
 */
class AddDataImportPluginTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDataImportPluginFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--entity' => 'FooBarItem',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Communication/Plugin/DataImport/FooBarItemDataImportPlugin.php',
        );
    }

    /**
     * @return void
     */
    public function testAddsDataImportPluginFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--entity' => 'FooBarItem',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Communication/Plugin/DataImport/FooBarItemDataImportPlugin.php',
        );
    }
}
