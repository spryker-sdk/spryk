<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Loader;

use Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface;
use Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationLoader implements SprykConfigurationLoaderInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface
     */
    protected $configurationFinder;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface
     */
    protected $configurationMerger;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Finder\SprykConfigurationFinderInterface $configurationFinder
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Merger\SprykConfigurationMergerInterface $configurationMerger
     */
    public function __construct(SprykConfigurationFinderInterface $configurationFinder, SprykConfigurationMergerInterface $configurationMerger)
    {
        $this->configurationFinder = $configurationFinder;
        $this->configurationMerger = $configurationMerger;
    }

    /**
     * @param string $sprykName
     *
     * @return array
     */
    public function loadSpryk(string $sprykName): array
    {
        $sprykConfiguration = $this->configurationFinder->find($sprykName);

        $sprykConfiguration = Yaml::parse($sprykConfiguration->getContents());

        return $this->configurationMerger->merge($sprykConfiguration);
    }
}
