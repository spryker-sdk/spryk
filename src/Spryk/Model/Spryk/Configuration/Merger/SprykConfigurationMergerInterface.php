<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Configuration\Merger;

/**
 * Merge project root configuration with a Spryk definition.
 */
interface SprykConfigurationMergerInterface
{
    /**
     * @param array $sprykDefinition
     * @param array $rootConfiguration
     *
     * @return array
     */
    public function merge(array $sprykDefinition, array $rootConfiguration): array;
}
