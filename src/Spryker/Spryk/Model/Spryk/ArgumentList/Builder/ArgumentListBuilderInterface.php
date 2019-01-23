<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ArgumentList\Builder;

interface ArgumentListBuilderInterface
{
    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    public function buildArgumentList(array $sprykDefinitions): array;
}
