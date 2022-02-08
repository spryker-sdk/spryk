<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Loader;

use SprykerSdk\Spryk\Exception\SprykConfigNotValid;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationLoader implements SprykConfigurationLoaderInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    protected SprykConfigurationFinderInterface $configurationFinder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected SprykConfigurationExtenderInterface $configurationExtender;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface
     */
    protected ConfigurationValidatorInterface $configurationValidator;

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $sprykConfig;

    /**
     * @var array<string, mixed>|null
     */
    protected ?array $rootConfiguration = null;

    /**
     * @var array<string, array>
     */
    protected array $loadedConfigurations = [];

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface $configurationFinder
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface $configurationExtender
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface $configurationValidator
     * @param \SprykerSdk\Spryk\SprykConfig $sprykConfig
     */
    public function __construct(
        SprykConfigurationFinderInterface $configurationFinder,
        SprykConfigurationExtenderInterface $configurationExtender,
        ConfigurationValidatorInterface $configurationValidator,
        SprykConfig $sprykConfig
    ) {
        $this->configurationFinder = $configurationFinder;
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
        $sprykConfiguration = $this->load($sprykName);

        $sprykConfiguration = $this->buildMode($sprykConfiguration, $sprykMode);
        $sprykConfiguration = $this->buildLevel($sprykConfiguration);

        return $this->configurationExtender->extend($sprykConfiguration);
    }

    /**
     * @param string $sprykName
     *
     * @return array
     */
    protected function load(string $sprykName): array
    {
        if (!isset($this->loadedConfigurations[$sprykName])) {
            $sprykConfiguration = $this->configurationFinder->find($sprykName);
            $this->loadedConfigurations[$sprykName] = Yaml::parse($sprykConfiguration->getContents());
        }

        return $this->loadedConfigurations[$sprykName];
    }

    /**
     * @return array
     */
    protected function getRootConfiguration(): array
    {
        if (!$this->rootConfiguration) {
            $rootConfiguration = $this->configurationFinder->find('spryk');
            $this->rootConfiguration = Yaml::parse($rootConfiguration->getContents());
        }

        return $this->rootConfiguration;
    }

    /**
     * @param array $sprykConfiguration
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykConfigNotValid
     *
     * @return void
     */
    protected function validateConfiguration(array $sprykConfiguration): void
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
