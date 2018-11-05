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
 * @group AddZedBusinessTestSuiteConfigurationTest
 * Add your own group annotations below this line
 */
class AddZedBusinessTestSuiteConfigurationTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
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

        $targetFile = $this->tester->getModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/codeception.yml';
        static::assertFileExists($targetFile);

        $fileContent = file_get_contents($targetFile);
        $configuration = Yaml::parse(($fileContent) ?: '');
        static::assertArrayHasKey('suites', $configuration);

        $suitesConfiguration = $configuration['suites'];
        static::assertArrayHasKey('Business', $suitesConfiguration);
    }
}
