<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Loader;

interface SprykConfigurationLoaderInterface
{
    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function loadSpryk(string $sprykName, ?string $sprykMode = null): array;
}
