<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Finder;

use SprykerSdk\Spryk\Exception\SprykConfigFileNotFoundException;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SprykConfigurationFinder implements SprykConfigurationFinderInterface
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $sprykName
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykConfigFileNotFoundException
     *
     * @return \Symfony\Component\Finder\SplFileInfo
     */
    public function find(string $sprykName): SplFileInfo
    {
        $finder = $this->buildFinder($sprykName);

        if (!$finder->hasResults()) {
            throw new SprykConfigFileNotFoundException(sprintf('Could not find Spryk config file for "%s"', $sprykName));
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
        $finder->in($this->config->getSprykDirectories())->name($fileName);

        return $finder;
    }
}
