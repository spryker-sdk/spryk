<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest;

use Codeception\Actor;
use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class SprykTester extends Actor
{
    use _generated\SprykTesterActions;

    /**
     * @return string
     */
    public function getRootDirectory(): string
    {
        return codecept_data_dir();
    }

    /**
     * @param string $module
     *
     * @return string
     */
    public function getModuleDirectory(string $module = 'FooBar'): string
    {
        return sprintf('%svendor/spryker/spryker/Bundles/%s/', $this->getRootDirectory(), $module);
    }

    /**
     * @param string $directory
     *
     * @return array
     */
    public function getMergedConfiguration(string $directory)
    {
        $configurationFinder = new SprykConfigurationFinder([$directory . '/Fixtures/config/']);
        $configurationMerger = new SprykConfigurationMerger($configurationFinder);

        $configurationFinder = new SprykConfigurationFinder([$directory . '/Fixtures/config/spryks/']);
        $configurationLoader = new SprykConfigurationLoader($configurationFinder, $configurationMerger);

        return $configurationLoader->loadSpryk('SprykDefinition');
    }
}
