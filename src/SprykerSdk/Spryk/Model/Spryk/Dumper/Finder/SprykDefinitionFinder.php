<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Dumper\Finder;

use Symfony\Component\Finder\Finder;

class SprykDefinitionFinder implements SprykDefinitionFinderInterface
{
    /**
     * @var string[]
     */
    protected $sprykDirectories;

    /**
     * @param string[] $sprykDirectories
     */
    public function __construct(array $sprykDirectories)
    {
        $this->sprykDirectories = $sprykDirectories;
    }

    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]|\Symfony\Component\Finder\Finder
     */
    public function find(): iterable
    {
        $finder = new Finder();
        $finder->in($this->sprykDirectories)->files();

        return $finder;
    }
}
