<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Model\Spryk\ConfigurationLoader;

use Codeception\Test\Unit;
use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Model
 * @group Spryk
 * @group ConfigurationLoader
 * @group SprykConfigurationLoaderTest
 * Add your own group annotations below this line
 */
class SprykConfigurationLoaderTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValuesWithRootConfigurationValues(): void
    {
        $configurationFinder = new SprykConfigurationFinder([__DIR__ . '/Fixtures/config/']);
        $configurationMerger = new SprykConfigurationMerger($configurationFinder);

        $configurationFinder = new SprykConfigurationFinder([__DIR__ . '/Fixtures/config/spryks/']);
        $configurationLoader = new SprykConfigurationLoader($configurationFinder, $configurationMerger);

        $sprykConfiguration = $configurationLoader->loadSpryk('SprykDefinition');
        $this->assertInternalType('array', $sprykConfiguration);
        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration['arguments']['targetPath']);
    }
}
