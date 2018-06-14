<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Dumper;

use Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface;

class SprykDefinitionDumper implements SprykDefinitionDumperInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface
     */
    protected $definitionFinder;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected $configurationLoader;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface $definitionFinder
     * @param \Spryker\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $configurationLoader
     */
    public function __construct(SprykDefinitionFinderInterface $definitionFinder, SprykConfigurationLoaderInterface $configurationLoader)
    {
        $this->definitionFinder = $definitionFinder;
        $this->configurationLoader = $configurationLoader;
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        $sprykDefinitions = [];
        foreach ($this->definitionFinder->find() as $fileInfo) {
            $sprykName = str_replace('.' . $fileInfo->getExtension(), '', $fileInfo->getFilename());
            $sprykDefinition = $this->configurationLoader->loadSpryk($sprykName);

            $sprykDefinitions[$sprykName] = $sprykDefinition;
        }

        return $sprykDefinitions;
    }
}
