<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Finder;

use SprykerSdk\Spryk\Exception\SprykConfigFileNotFound;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SprykConfigurationFinder implements SprykConfigurationFinderInterface
{
    /**
     * @var string[]
     */
    protected $directories;

    /**
     * @param string[] $directories
     */
    public function __construct(array $directories)
    {
        $this->directories = $directories;
    }

    /**
     * @param string $sprykName
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykConfigFileNotFound
     *
     * @return \Symfony\Component\Finder\SplFileInfo
     */
    public function find(string $sprykName): SplFileInfo
    {
        $finder = $this->buildFinder($sprykName);

        if (!$finder->hasResults()) {
            throw new SprykConfigFileNotFound(sprintf('Could not find Spryk config file for "%s"', $sprykName));
        }

        $iterator = $finder->getIterator();
        $iterator->rewind();

        return $iterator->current();
    }

    /**
     * @param string $sprykName
     *
     * @return \Symfony\Component\Finder\Finder
     */
    protected function buildFinder(string $sprykName): Finder
    {
        $fileName = sprintf('%s.yml', $sprykName);

        $finder = new Finder();
        $finder->in($this->directories)->name($fileName);

        return $finder;
    }
}
