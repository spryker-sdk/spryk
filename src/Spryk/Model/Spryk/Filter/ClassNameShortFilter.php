<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to convert a FQCN string
 * into a string containing only the class name.
 *
 * Example:
 * $this->filter(`\Organization\Module\ClassName') === 'ClassName';
 */
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
        $classNameShort = array_pop($classNameFragments);

        return $classNameShort;
    }
}
