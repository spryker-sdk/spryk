<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
     * @phpstan-return array<mixed>
     *
     * @param int|null $level
     *
     * @return array
     */
    public function dump(?int $level = null): array
    {
        $sprykDefinitions = [];
        foreach ($this->definitionFinder->find() as $fileInfo) {
            $sprykName = str_replace('.' . $fileInfo->getExtension(), '', $fileInfo->getFilename());
            $sprykDefinition = $this->configurationLoader->loadSpryk($sprykName);

            if ($level === null || $level === (int)$sprykDefinition['level']) {
                $sprykDefinitions[$sprykName] = $sprykDefinition;
            }
        }

        ksort($sprykDefinitions);

        return $sprykDefinitions;
    }
}
