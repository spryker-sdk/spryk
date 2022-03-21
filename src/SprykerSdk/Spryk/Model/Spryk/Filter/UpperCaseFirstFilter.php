<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to upper the case of a first letter of the string.
 *
 * Example:
 * $this->filter(`className') === 'ClassName';
 */
class UpperCaseFirstFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ucfirst';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        return ucfirst($value);
    }
}
