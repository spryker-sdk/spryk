<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class RemoveControllerSuffixFilter implements FilterInterface
{
    public const CONTROLLER_SUFFIX = 'Controller';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'removeControllerSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::CONTROLLER_SUFFIX)) === static::CONTROLLER_SUFFIX) {
            $value = mb_substr($value, 0, mb_strlen($value) - mb_strlen(static::CONTROLLER_SUFFIX));
        }

        return ucfirst($value);
    }
}
