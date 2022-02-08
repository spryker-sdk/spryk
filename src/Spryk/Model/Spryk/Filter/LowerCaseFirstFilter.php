<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to lower the case of a first letter of the string.
 *
 * Example:
 * $this->filter(`ClassName') === 'className';
 */
class LowerCaseFirstFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'lcfirst';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        return lcfirst($value);
    }
}
