<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Dumper\Finder;

interface SprykDefinitionFinderInterface
{
    /**
     * @return \Symfony\Component\Finder\SplFileInfo[]|\Symfony\Component\Finder\Finder
     */
    public function find(): iterable;
}
