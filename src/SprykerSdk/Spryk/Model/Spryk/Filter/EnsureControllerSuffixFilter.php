<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class EnsureControllerSuffixFilter implements FilterInterface
{
    public const CONTROLLER_SUFFIX = 'Controller';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ensureControllerSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::CONTROLLER_SUFFIX)) !== static::CONTROLLER_SUFFIX) {
            $value = $value . static::CONTROLLER_SUFFIX;
        }

        return ucfirst($value);
    }
}
