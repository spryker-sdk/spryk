<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ArgumentList\Generator;

interface ArgumentListGeneratorInterface
{
    /**
     * @param array $sprykDefinitions
     *
     * @return int
     */
    public function generateArgumentList(array $sprykDefinitions): int;
}
