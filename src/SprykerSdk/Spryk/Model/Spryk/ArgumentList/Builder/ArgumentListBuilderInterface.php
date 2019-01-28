<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder;

interface ArgumentListBuilderInterface
{
    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    public function buildArgumentList(array $sprykDefinitions): array;
}
