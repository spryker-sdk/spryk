<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToDash;

class DasherizeFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'dasherize';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new CamelCaseToDash())
            ->attach(new StringToLower());

        return $filterChain->filter($value);
    }
}
