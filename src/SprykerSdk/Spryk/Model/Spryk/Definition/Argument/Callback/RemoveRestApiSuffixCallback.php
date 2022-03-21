<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class RemoveRestApiSuffixCallback implements CallbackInterface
{
    /**
     * @var string
     */
    protected const RESTAPI_SUFFIX = 'RestApi';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'RemoveRestApiSuffix';
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

        if (mb_strpos($value, static::RESTAPI_SUFFIX) === false) {
            return $value;
        }

        return mb_substr($value, 0, mb_strlen($value) - mb_strlen(static::RESTAPI_SUFFIX));
    }
}
