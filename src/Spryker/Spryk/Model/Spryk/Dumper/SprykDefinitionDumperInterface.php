<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Dumper;

interface SprykDefinitionDumperInterface
{
    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    public function dump(): array;
}
