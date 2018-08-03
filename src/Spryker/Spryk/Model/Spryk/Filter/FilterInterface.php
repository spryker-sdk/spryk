<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Filter;

interface FilterInterface
{
    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string;
}
