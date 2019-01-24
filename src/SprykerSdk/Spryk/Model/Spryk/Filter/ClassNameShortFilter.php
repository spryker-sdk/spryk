<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
