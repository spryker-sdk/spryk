<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
