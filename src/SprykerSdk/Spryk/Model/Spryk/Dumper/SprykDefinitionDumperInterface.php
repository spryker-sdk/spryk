<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Dumper;

interface SprykDefinitionDumperInterface
{
    /**
     * @return array
     */
    public function dump(): array;
}
