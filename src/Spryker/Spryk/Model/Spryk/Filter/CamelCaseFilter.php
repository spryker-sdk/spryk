<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Filter;

use Zend\Filter\FilterChain;
use Zend\Filter\Word\UnderscoreToCamelCase;

class CamelCaseFilter implements FilterInterface
{
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
