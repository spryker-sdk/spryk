<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Dumper;

use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface;

class SprykDefinitionDumper implements SprykDefinitionDumperInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface
     */
    protected $definitionFinder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected $configurationLoader;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface $definitionFinder
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $configurationLoader
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
