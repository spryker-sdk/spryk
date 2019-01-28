<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class ClassNameShortFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'classNameShort';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (strpos($value, '\\') === false) {
            return $value;
        }
        $classNameFragments = explode('\\', $value);
        $classNameShort = (string)array_pop($classNameFragments);

        return $classNameShort;
    }
}
