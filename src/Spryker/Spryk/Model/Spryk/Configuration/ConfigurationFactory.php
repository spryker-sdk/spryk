<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration;

use Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders\ApplicationLayerExtender;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders\DevelopmentLayerExtender;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders\DirectoriesExtender;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders\OrganizationExtender;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\Extenders\TargetPathExtender;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtender;
use Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidator;
use Spryker\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Validator\Rules\DevelopmentLayerRule;
use Spryker\Spryk\SprykConfig;

class ConfigurationFactory
{
    /**
     * @var \Spryker\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @param \Spryker\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    public function createConfigurationFinder(array $directories): SprykConfigurationFinderInterface
    {
        return new SprykConfigurationFinder($directories);
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Validator\ConfigurationValidatorInterface
     */
    public function createConfigurationValidator(): ConfigurationValidatorInterface
    {
        return new ConfigurationValidator(
            $this->createConfigurationValidatorRules()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    public function createConfigurationExtender(): SprykConfigurationExtenderInterface
    {
        return new SprykConfigurationExtender(
            $this->getConfigurationExtenders()
        );
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface[]
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
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createOrganizationExtender(): SprykConfigurationExtenderInterface
    {
        return new OrganizationExtender($this->config);
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createDirectoriesExtender(): SprykConfigurationExtenderInterface
    {
        return new DirectoriesExtender($this->config);
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createTargetPathExtender(): SprykConfigurationExtenderInterface
    {
        return new TargetPathExtender($this->config);
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Configuration\Extender\SprykConfigurationExtenderInterface
     */
    protected function createDevelopmentLayerExtender(): SprykConfigurationExtenderInterface
    {
        return new DevelopmentLayerExtender($this->config);
    }
}
