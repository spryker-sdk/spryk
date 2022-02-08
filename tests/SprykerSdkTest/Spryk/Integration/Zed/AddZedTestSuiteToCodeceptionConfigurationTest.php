<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\SprykWrongDevelopmentLayerException;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group AddZedTestSuiteToCodeceptionConfigurationTest
 * Add your own group annotations below this line
 */
class AddZedTestSuiteToCodeceptionConfigurationTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedTestSuiteToCodeceptionConfiguration(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'codeception.yml');
    }

    /**
     * @return void
     */
    public function testAddZedTestSuiteToCodeceptionConfigurationFailsOnProjectLayer(): void
    {
        $this->expectException(SprykWrongDevelopmentLayerException::class);

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);
    }

    /**
     * @return void
     */
    public function testAddsZedTestSuiteToCodeceptionConfigurationOnlyOnce(): void
    {
        $this->tester->run($this, ['--module' => 'FooBar']);
        $this->tester->run($this, ['--module' => 'FooBar']);

        $configurationFilePath = $this->tester->getSprykerModuleDirectory() . 'codeception.yml';
        $this->assertFileExists($configurationFilePath);

        $fileContent = file_get_contents($configurationFilePath);

        $yaml = Yaml::parse(($fileContent) ?: '');
        $this->assertCount(1, $yaml['include']);
    }
}
