<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class EnsureInterfaceSuffixCallback implements CallbackInterface
{
    /**
     * @var string
     */
    protected const INTERFACE_SUFFIX = 'Interface';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'EnsureInterfaceSuffix';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        $value = (string)$value;

        if (mb_substr($value, - mb_strlen(static::INTERFACE_SUFFIX)) !== static::INTERFACE_SUFFIX) {
            $value = $value . static::INTERFACE_SUFFIX;
        }

        return ucfirst($value);
    }
}
