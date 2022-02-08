<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication;

use Codeception\Test\Unit;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group AddZedCommunicationTestSuiteConfigurationTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationTestSuiteConfigurationTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedCommunicationTestSuiteConfiguration(): void
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
        $this->assertArrayHasKey('Communication', $suitesConfiguration);
    }

    /**
     * @return void
     */
    public function testAddsZedCommunicationTestSuiteConfigurationOnProjectLayer(): void
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
        $this->assertArrayHasKey('Communication', $suitesConfiguration);
    }
}
