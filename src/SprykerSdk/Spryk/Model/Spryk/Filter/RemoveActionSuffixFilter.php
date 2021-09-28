<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to remove the `Action` suffix from a string
 * if it is present in the given one.
 *
 * Example:
 * $this->filter('indexAction') === `index';
 * $this->filter('list') === `list';
 */
class RemoveActionSuffixFilter implements FilterInterface
{
    /**
     * @var string
     */
    public const ACTION_SUFFIX = 'Action';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'removeActionSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::ACTION_SUFFIX)) === static::ACTION_SUFFIX) {
            $value = mb_substr($value, 0, mb_strlen($value) - mb_strlen(static::ACTION_SUFFIX));
        }

        return ucfirst($value);
    }
}
