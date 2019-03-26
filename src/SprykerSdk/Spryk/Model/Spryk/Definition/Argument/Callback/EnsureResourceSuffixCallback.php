<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class EnsureResourceSuffixCallback implements CallbackInterface
{
    public const RESOURCE_SUFFIX = 'Resource';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'EnsureResourceSuffix';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        if (mb_substr($value, - mb_strlen(static::RESOURCE_SUFFIX)) !== static::RESOURCE_SUFFIX) {
            $value = $value . static::RESOURCE_SUFFIX;
        }

        return ucfirst($value);
    }
}
