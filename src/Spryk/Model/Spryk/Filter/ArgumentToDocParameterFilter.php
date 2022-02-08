<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to convert a string
 * representing an argument description into a PHPDoc {@param} string.
 *
 * Example:
 * $this->filter(`string $argument') === 'string $argument';
 * $this->filter(`?string $argument = null`) === 'string|null $argument';
 * $this->filter(`array $argument = []`) === 'array $argument';
 */
class ArgumentToDocParameterFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'argumentToDocParameter';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $value = trim($value);

        $argumentParts = explode(' ', $value);

        if (mb_substr($argumentParts[0], 0, 1) === '?') {
            return sprintf(
                '%s|null %s',
                mb_substr($argumentParts[0], 1),
                $argumentParts[1],
            );
        }

        if (!empty($argumentParts[2]) && $argumentParts[2] === '=') {
            return sprintf(
                '%s %s',
                $argumentParts[0],
                $argumentParts[1],
            );
        }

        return $value;
    }
}
