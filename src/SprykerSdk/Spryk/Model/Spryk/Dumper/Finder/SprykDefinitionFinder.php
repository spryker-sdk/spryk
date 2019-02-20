<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
