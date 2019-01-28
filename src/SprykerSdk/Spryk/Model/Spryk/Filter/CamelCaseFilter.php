<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Zend\Filter\FilterChain;
use Zend\Filter\Word\UnderscoreToCamelCase;

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
