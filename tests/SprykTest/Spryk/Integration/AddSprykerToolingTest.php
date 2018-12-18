<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddSprykerToolingTest
 * Add your own group annotations below this line
 */
class AddSprykerToolingTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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

        static::assertFileExists($this->getToolingFilePath());

        return $this->getToolingConfigByFilePath($this->getToolingFilePath());
    }

    /**
     * @depends testAddsToolingFile
     *
     * @param array $toolingConfig
     *
     * @return void
     */
    public function testChecksToolingConfigParams(array $toolingConfig): void
    {
        static::assertEquals($this->getDefaultToolingConfig(), $toolingConfig);
    }

    /**
     * @return array
     */
    protected function getDefaultToolingConfig(): array
    {
        return [
            'architecture-sniffer' => [
                'priority' => 2,
            ],
            'code-sniffer' => [
                'level' => 1,
            ],
        ];
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
