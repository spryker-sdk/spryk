<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class RemoveWidgetSuffixFilter implements FilterInterface
{
    public const WIDGET_SUFFIX = 'Widget';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'removeWidgetSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::WIDGET_SUFFIX)) === static::WIDGET_SUFFIX) {
            $value = mb_substr($value, 0, mb_strlen($value) - mb_strlen(static::WIDGET_SUFFIX));
        }

        return ucfirst($value);
    }
}
