<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Loader;

use SprykerSdk\Spryk\Exception\SprykConfigNotValid;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationLoader implements SprykConfigurationLoaderInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    protected $configurationFinder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
     */
    protected $configurationMerger;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected $configurationExtender;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface
     */
    protected $configurationValidator;

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected $sprykConfig;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface $configurationFinder
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface $configurationMerger
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface $configurationExtender
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface $configurationValidator
     * @param \SprykerSdk\Spryk\SprykConfig $sprykConfig
     */
    public function __construct(
        SprykConfigurationFinderInterface $configurationFinder,
        SprykConfigurationMergerInterface $configurationMerger,
        SprykConfigurationExtenderInterface $configurationExtender,
        ConfigurationValidatorInterface $configurationValidator,
        SprykConfig $sprykConfig
    ) {
        $this->configurationFinder = $configurationFinder;
        $this->configurationMerger = $configurationMerger;
        $this->configurationExtender = $configurationExtender;
        $this->configurationValidator = $configurationValidator;
        $this->sprykConfig = $sprykConfig;
    }

    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function loadSpryk(string $sprykName, ?string $sprykMode = null): array
    {
        $sprykConfiguration = $this->configurationFinder->find($sprykName);
        $sprykConfiguration = Yaml::parse($sprykConfiguration->getContents());

        $sprykConfiguration = $this->buildMode($sprykConfiguration, $sprykMode);
        $sprykConfiguration = $this->buildLevel($sprykConfiguration);

        $this->configurationValidate($sprykConfiguration);

        $sprykConfiguration = $this->configurationMerger->merge($sprykConfiguration);

        return $this->configurationExtender->extend($sprykConfiguration);
    }

    /**
     * @param array $sprykConfiguration
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykConfigNotValid
     *
     * @return void
     */
    protected function configurationValidate(array $sprykConfiguration): void
    {
        $validationErrorMessages = $this->configurationValidator->validate($sprykConfiguration);

        if ($validationErrorMessages === []) {
            return;
        }

        throw new SprykConfigNotValid(implode(PHP_EOL, $validationErrorMessages));
    }

    /**
     * @param array $sprykConfiguration
     * @param string|null $sprykMode
     *
     * @return array
     */
    protected function buildMode(array $sprykConfiguration, ?string $sprykMode = null): array
    {
        if (!isset($sprykConfiguration[SprykConfig::NAME_ARGUMENT_MODE])) {
            $sprykConfiguration[SprykConfig::NAME_ARGUMENT_MODE] = $this->sprykConfig->getDefaultDevelopmentMode();
        }

        if ($sprykMode !== null && $sprykConfiguration[SprykConfig::NAME_ARGUMENT_MODE] === 'both') {
            $sprykConfiguration[SprykConfig::NAME_ARGUMENT_MODE] = $sprykMode;
        }

        return $sprykConfiguration;
    }

    /**
     * @param array $sprykConfiguration
     *
     * @return array
     */
    protected function buildLevel(array $sprykConfiguration): array
    {
        if (!isset($sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_LEVEL])) {
            $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_LEVEL] = $this->sprykConfig->getDefaultBuildLevel();
        }

        return $sprykConfiguration;
    }
}
