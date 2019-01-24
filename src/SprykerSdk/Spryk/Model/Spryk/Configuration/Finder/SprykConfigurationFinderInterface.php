<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Finder;

use Symfony\Component\Finder\SplFileInfo;

interface SprykConfigurationFinderInterface
{
    /**
     * @param string $sprykName
     *
     * @return \Symfony\Component\Finder\SplFileInfo
     */
    public function find(string $sprykName): SplFileInfo;
}
