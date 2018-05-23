<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration;

use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinder;
use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoader;
use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMerger;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
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
            $this->createConfigurationMerger()
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
}
