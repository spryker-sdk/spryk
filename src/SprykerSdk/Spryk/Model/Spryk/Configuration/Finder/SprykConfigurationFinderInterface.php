<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
