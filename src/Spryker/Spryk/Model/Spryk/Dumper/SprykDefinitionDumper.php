<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Dumper;

use Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface;

class SprykDefinitionDumper implements SprykDefinitionDumperInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface
     */
    protected $definitionFinder;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Dumper\Finder\SprykDefinitionFinderInterface $definitionFinder
     */
    public function __construct(SprykDefinitionFinderInterface $definitionFinder)
    {
        $this->definitionFinder = $definitionFinder;
    }

    /**
     * @return array
     */
    public function dump(): array
    {
        $sprykDefinitions = [];
        foreach ($this->definitionFinder->find() as $fileInfo) {
            $sprykName = str_replace('.' . $fileInfo->getExtension(), '', $fileInfo->getFilename());
            $sprykDefinitions[$sprykName] = $sprykName;
        }

        return $sprykDefinitions;
    }
}
