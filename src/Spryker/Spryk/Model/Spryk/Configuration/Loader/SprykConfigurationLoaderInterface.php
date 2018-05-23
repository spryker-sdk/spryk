<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Configuration\Loader;

interface SprykConfigurationLoaderInterface
{
    /**
     * @param string $sprykName
     *
     * @return array
     */
    public function loadSpryk(string $sprykName): array;
}
