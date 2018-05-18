<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ConfigurationLoader;

use Spryker\Spryk\Exception\SprykConfigFileNotFound;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Yaml\Yaml;

class SprykConfigurationLoader implements SprykConfigurationLoaderInterface
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
     * @param string $sprykName
     *
     * @throws \Spryker\Spryk\Exception\SprykConfigFileNotFound
     *
     * @return array
     */
    public function loadSpryk(string $sprykName): array
    {
        $fileName = sprintf('%s.yml', $sprykName);

        $finder = new Finder();
        $finder->in($this->sprykDirectories)->name($fileName);

        if (!$finder->hasResults()) {
            throw new SprykConfigFileNotFound(sprintf('Could not find Spryk config file for "%s"', $sprykName));
        }

        $iterator = $finder->getIterator();
        $iterator->rewind();

        $sprykConfigFile = $iterator->current();

        return Yaml::parse($sprykConfigFile->getContents());
    }
}
