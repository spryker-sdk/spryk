<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class EnsureActionSuffixCallback implements CallbackInterface
{
    public const ACTION_SUFFIX = 'Action';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'EnsureActionSuffixCallback';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        if (mb_substr($value, - mb_strlen(static::ACTION_SUFFIX)) !== static::ACTION_SUFFIX) {
            $value = $value . static::ACTION_SUFFIX;
        }

        return lcfirst($value);
    }
}
