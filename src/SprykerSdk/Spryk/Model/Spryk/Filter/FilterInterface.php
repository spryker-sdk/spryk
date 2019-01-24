<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

interface FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string;
}
