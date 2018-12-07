<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed;

use Codeception\Test\Unit;
use Symfony\Component\Yaml\Yaml;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group AddZedTestSuiteToCodeceptionConfigurationTest
 * Add your own group annotations below this line
 */
class AddZedTestSuiteToCodeceptionConfigurationTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedTestSuiteToCodeceptionConfiguration(): void
    {
        $this->tester->run($this, [
            '--moduleName' => 'FooBar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'codeception.yml');
    }

    /**
     * @return void
     */
    public function testAddsZedTestSuiteToCodeceptionConfigurationOnlyOnce(): void
    {
        $this->tester->run($this, ['--moduleName' => 'FooBar']);
        $this->tester->run($this, ['--moduleName' => 'FooBar']);

        $configurationFilePath = $this->tester->getModuleDirectory() . 'codeception.yml';
        static::assertFileExists($configurationFilePath);

        $fileContent = file_get_contents($configurationFilePath);

        $yaml = Yaml::parse(($fileContent) ?: '');
        static::assertCount(1, $yaml['include']);
    }
}
