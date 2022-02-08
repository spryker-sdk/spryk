<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Module\DataImport\Zed\Business\Model;

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
 * @group Business
 * @group Model
 * @group AddDataImportZedBusinessWriterStepTest
 * Add your own group annotations below this line
 */
class AddDataImportZedBusinessWriterStepTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDataImportZedBusinessWriterStepFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Writer',
            '--className' => 'FooBarItemWriter',
            '--constructorArguments' => [
                '\Spryker\Zed\FooBar\Business\Foo\Zip $zip',
                '\Spryker\Zed\FooBar\Business\Foo\Zap $zap',
            ],
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/Writer/FooBarItemWriter.php',
        );
    }

    /**
     * @return void
     */
    public function testAddsDataImportZedBusinessWriterStepFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Writer',
            '--className' => 'FooBarItemWriter',
            '--constructorArguments' => [
                '\Spryker\Zed\FooBar\Business\Foo\Zip $zip',
                '\Spryker\Zed\FooBar\Business\Foo\Zap $zap',
            ],
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Business/Writer/FooBarItemWriter.php',
        );
    }
}
