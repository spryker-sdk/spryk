<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ConfigurationLoader;

interface SprykConfigurationLoaderInterface
{
    /**
     * @param string $sprykName
     *
     * @return array
     */
    public function loadSpryk(string $sprykName): array;
}
