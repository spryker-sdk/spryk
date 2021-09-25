<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\DashToUnderscore;

/**
 * Filter is used to convert a string where words are separated by "-"
 * into an underscored string.
 *
 * Example:
 * $this->filter('string-example') === `string_example';
 */
class DashToUnderscoreFilter implements FilterInterface
{
    /**
     * @var string
     */
    protected const FILTER_NAME = 'dashToUnderscore';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::FILTER_NAME;
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        $filterChain = new FilterChain();
        $filterChain->attach(new DashToUnderscore());

        return $filterChain->filter($value);
    }
}
