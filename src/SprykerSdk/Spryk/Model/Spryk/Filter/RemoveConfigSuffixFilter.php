<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to remove the `Controller` suffix from a string
 * if it is present in the given one.
 *
 * Example:
 * $this->filter('FooBarConfig') === `FooBar';
 * $this->filter('List') === `List';
 */
class RemoveConfigSuffixFilter implements FilterInterface
{
    /**
     * @var string
     */
    public const CONFIG_SUFFIX = 'Config';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'removeConfigSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::CONFIG_SUFFIX)) === static::CONFIG_SUFFIX) {
            $value = mb_substr($value, 0, mb_strlen($value) - mb_strlen(static::CONFIG_SUFFIX));
        }

        return ucfirst($value);
    }
}
