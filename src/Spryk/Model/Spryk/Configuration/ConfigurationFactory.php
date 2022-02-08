<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\ApplicationLayerExtenderPlugin;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\DefaultValueExtenderPlugin;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\DevelopmentLayerExtenderPlugin;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\DirectoriesExtenderPlugin;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\OrganizationExtenderPlugin;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\TargetPathExtenderPlugin;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidator;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\DevelopmentLayerRule;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\LevelRule;
use SprykerSdk\Spryk\SprykConfig;

class ConfigurationFactory
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    public function createConfigurationLoader(): SprykConfigurationLoaderInterface
    {
        return new SprykConfigurationLoader(
            $this->createConfigurationFinder($this->config->getSprykDirectories()),
            $this->createConfigurationMerger(),
            $this->createConfigurationExtender(),
            $this->createConfigurationValidator(),
            $this->getConfig(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
     */
    public function createConfigurationMerger(): SprykConfigurationMergerInterface
    {
        return new SprykConfigurationMerger(
            $this->createConfigurationFinder($this->config->getRootSprykDirectories()),
        );
    }

    /**
     * @param array<string> $directories
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    public function createConfigurationFinder(array $directories): SprykConfigurationFinderInterface
    {
        return new SprykConfigurationFinder($directories);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface
     */
    public function createConfigurationValidator(): ConfigurationValidatorInterface
    {
        return new ConfigurationValidator(
            $this->createConfigurationValidatorRules(),
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    public function createConfigurationExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new SprykConfigurationExtender(
            $this->getConfigurationExtenders(),
        );
    }

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface>
     */
    protected function getConfigurationExtenders(): array
    {
        return [
            $this->createDevelopmentLayerExtender(),
            $this->createTargetPathExtender(),
            $this->createOrganizationExtender(),
            $this->createDirectoriesExtender(),
            $this->createApplicationLayerExtender(),
            $this->createDefaultValueExtender(),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    protected function createOrganizationExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new OrganizationExtenderPlugin($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    protected function createDirectoriesExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new DirectoriesExtenderPlugin($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    protected function createApplicationLayerExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new ApplicationLayerExtenderPlugin($this->config);
    }

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface>
     */
    protected function createConfigurationValidatorRules(): array
    {
        return [
            $this->createDevelopmentLayerRule(),
            $this->createLevelRule(),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface
     */
    protected function createDevelopmentLayerRule(): ConfigurationValidatorRuleInterface
    {
        return new DevelopmentLayerRule($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\ConfigurationValidatorRuleInterface
     */
    protected function createLevelRule(): ConfigurationValidatorRuleInterface
    {
        return new LevelRule($this->config->getAvailableLevels());
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    protected function createTargetPathExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new TargetPathExtenderPlugin($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    protected function createDevelopmentLayerExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new DevelopmentLayerExtenderPlugin($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderPluginInterface
     */
    public function createDefaultValueExtender(): SprykConfigurationExtenderPluginInterface
    {
        return new DefaultValueExtenderPlugin($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\SprykConfig
     */
    public function getConfig(): SprykConfig
    {
        if ($this->config === null) {
            $this->config = new SprykConfig();
        }

        return $this->config;
    }
}
