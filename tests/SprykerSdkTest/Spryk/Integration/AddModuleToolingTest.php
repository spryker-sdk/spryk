<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddModuleToolingTest
 * Add your own group annotations below this line
 */
class AddModuleToolingTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return array
     */
    public function testAddsToolingFile(): array
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ]);

        $this->assertFileExists($this->getToolingFilePath());

        return $this->getToolingConfigByFilePath($this->getToolingFilePath());
    }

    /**
     * @return void
     */
    public function testAddsToolingFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'tooling.yml');
    }

    /**
     * @depends testAddsToolingFile
     *
     * @param array $toolingConfig
     *
     * @return void
     */
    public function testChecksToolingConfigHasCodeSnifferBlock(array $toolingConfig): void
    {
        $this->assertArrayHasKey('code-sniffer', $toolingConfig);
    }

    /**
     * @param string $toolingFilePath
     *
     * @return array
     */
    protected function getToolingConfigByFilePath(string $toolingFilePath): array
    {
        return Yaml::parseFile($toolingFilePath);
    }

    /**
     * @return string
     */
    protected function getToolingFilePath(): string
    {
        return $this->tester->getModuleDirectory() . 'tooling.yml';
    }
}
