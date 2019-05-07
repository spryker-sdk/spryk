<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Merger;

interface SprykConfigurationMergerInterface
{
    /**
     * @param array $sprykDefinition
     * @param string|null $currentMode
     *
     * @return array
     */
    public function merge(array $sprykDefinition, ?string $currentMode): array;
}
