<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to convert a string
 * representing a return value description into a PHPDoc {@param} string.
 *
 * Example:
 * $this->filter(`string') === 'string';
 * $this->filter(`?string`) === 'string|null';
 */
class ReturnValueToDocParameterFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'returnValueToDocParameter';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $value = trim($value);

        if (mb_substr($value, 0, 1) === '?') {
            return sprintf(
                '%s|null',
                mb_substr($value, 1),
            );
        }

        return $value;
    }
}
