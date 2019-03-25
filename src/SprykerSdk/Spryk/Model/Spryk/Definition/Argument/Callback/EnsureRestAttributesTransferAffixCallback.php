<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class EnsureRestAttributesTransferAffixCallback implements CallbackInterface
{
    public const ACTION_PREFIX = 'Rest';
    public const ACTION_SUFFIX = 'Attributes';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'EnsureRestAttributesTransferAffix';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param mixed|null $value
     *
     * @return mixed
     */
    public function getValue(ArgumentCollectionInterface $argumentCollection, $value)
    {
        return sprintf(
            '%s%s%s',
            static::ACTION_PREFIX,
            ucfirst($value),
            static::ACTION_SUFFIX
        );
    }
}
