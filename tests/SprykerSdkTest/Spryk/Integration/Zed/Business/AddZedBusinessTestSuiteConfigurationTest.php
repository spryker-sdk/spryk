<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Business;

use Codeception\Test\Unit;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Business
 * @group AddZedBusinessTestSuiteConfigurationTest
 * Add your own group annotations below this line
 */
class AddZedBusinessTestSuiteConfigurationTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessTestSuiteConfiguration(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $targetFile = $this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/codeception.yml';
        $this->assertFileExists($targetFile);

        $fileContent = file_get_contents($targetFile);
        $configuration = Yaml::parse(($fileContent) ?: '');
        $this->assertArrayHasKey('suites', $configuration);

        $suitesConfiguration = $configuration['suites'];
        $this->assertArrayHasKey('Business', $suitesConfiguration);
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessTestSuiteConfigurationOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $targetFile = $this->tester->getProjectTestDirectory() . 'codeception.yml';
        $this->assertFileExists($targetFile);

        $fileContent = file_get_contents($targetFile);
        $configuration = Yaml::parse(($fileContent) ?: '');
        $this->assertArrayHasKey('suites', $configuration);

        $suitesConfiguration = $configuration['suites'];
        $this->assertArrayHasKey('Business', $suitesConfiguration);
    }
}
