<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest;

use Codeception\Actor;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidator;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollection;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\SprykConfig;

/**
 * Inherited Methods
 *
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
    public function getMergedConfiguration(string $directory): array
    {
        $configurationFinder = new SprykConfigurationFinder([$directory . '/Fixtures/config/']);
        $configurationMerger = new SprykConfigurationMerger($configurationFinder);

        $configurationFinder = new SprykConfigurationFinder([$directory . '/Fixtures/config/spryks/']);
        $configurationLoader = new SprykConfigurationLoader(
            $configurationFinder,
            $configurationMerger,
            new SprykConfigurationExtender([]),
            new ConfigurationValidator([]),
            new SprykConfig(),
        );

        return $configurationLoader->loadSpryk('SprykDefinition');
    }

    /**
     * @param array $arguments
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function getSprykDefinition(array $arguments): SprykDefinitionInterface
    {
        $sprykArgumentCollection = new ArgumentCollection();

        foreach ($arguments as $argumentKey => $argumentValue) {
            $sprykArgument = new Argument();
            $sprykArgument
                ->setName($argumentKey)
                ->setValue($argumentValue);

            $sprykArgumentCollection->addArgument($sprykArgument);
        }

        $sprykDefinition = new SprykDefinition();
        $sprykDefinition->setArgumentCollection($sprykArgumentCollection);

        return $sprykDefinition;
    }
}
