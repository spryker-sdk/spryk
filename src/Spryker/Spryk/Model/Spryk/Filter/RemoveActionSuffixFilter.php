<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Filter;

class RemoveActionSuffixFilter implements FilterInterface
{
    protected const ACTION_SUFFIX = 'Action';

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
