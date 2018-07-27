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
            '--module' => 'FooBar',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory() . 'codeception.yml');
    }

    /**
     * @return void
     */
    public function testAddsZedTestSuiteToCodeceptionConfigurationOnlyOnce(): void
    {
        $this->tester->run($this, ['--module' => 'FooBar']);
        $this->tester->run($this, ['--module' => 'FooBar']);

        $configurationFilePath = $this->tester->getModuleDirectory() . 'codeception.yml';
        $this->assertFileExists($configurationFilePath);

        $yaml = Yaml::parse(file_get_contents($configurationFilePath));
        $this->assertCount(1, $yaml['include']);
    }
}
