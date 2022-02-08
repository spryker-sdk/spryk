<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\CamelCaseToSeparator;

/**
 * Filter is used to convert a camelCased string
 * into a string where words are separated by " ".
 *
 * Example:
 * $this->filter(`stringExample') === 'string example';
 */
class CamelCaseToWhitespaceFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'camelCaseToWhitespace';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new CamelCaseToSeparator(' '));

        return $filterChain->filter($value);
    }
}
