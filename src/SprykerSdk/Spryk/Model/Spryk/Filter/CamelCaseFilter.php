<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\UnderscoreToCamelCase;

/**
 * Filter is used to convert an underscored string
 * into a camelCased one.
 *
 * Example:
 * $this->filter(`string_example') === 'stringExample';
 */
class CamelCaseFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'camelCased';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new UnderscoreToCamelCase());

        return $filterChain->filter($value);
    }
}
