<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\ApplicationLayerExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\DevelopmentLayerExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\DirectoriesExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\OrganizationExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\Extenders\TargetPathExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtender;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidator;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Validator\Rules\DevelopmentLayerRule;
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
            $this->createConfigurationValidator()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
     */
    public function createConfigurationMerger(): SprykConfigurationMergerInterface
    {
        return new SprykConfigurationMerger(
            $this->createConfigurationFinder($this->config->getRootSprykDirectories())
        );
    }

    /**
     * @param string[] $directories
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
            $this->createConfigurationValidatorRules()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    public function createConfigurationExtender(): SprykConfigurationExtenderInterface
    {
        return new SprykConfigurationExtender(
            $this->getConfigurationExtenders()
        );
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface[]
     */
    protected function getConfigurationExtenders(): array
    {
        return [
            $this->createDevelopmentLayerExtender(),
            $this->createTargetPathExtender(),
            $this->createOrganizationExtender(),
            $this->createDirectoriesExtender(),
            $this->createApplicationLayerExtender(),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createOrganizationExtender(): SprykConfigurationExtenderInterface
    {
        return new OrganizationExtender($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createDirectoriesExtender(): SprykConfigurationExtenderInterface
    {
        return new DirectoriesExtender($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createApplicationLayerExtender(): SprykConfigurationExtenderInterface
    {
        return new ApplicationLayerExtender($this->config);
    }

    /**
     * @return array
     */
    protected function createConfigurationValidatorRules(): array
    {
        return [
            new DevelopmentLayerRule($this->config->getAvailableDevelopmentLayers()),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createTargetPathExtender(): SprykConfigurationExtenderInterface
    {
        return new TargetPathExtender($this->config);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createDevelopmentLayerExtender(): SprykConfigurationExtenderInterface
    {
        return new DevelopmentLayerExtender($this->config);
    }
}
