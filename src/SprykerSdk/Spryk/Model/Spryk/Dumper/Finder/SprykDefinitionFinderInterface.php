<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Dumper\Finder;

interface SprykDefinitionFinderInterface
{
    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]|\Symfony\Component\Finder\Finder
     */
    public function find(): iterable;
}
