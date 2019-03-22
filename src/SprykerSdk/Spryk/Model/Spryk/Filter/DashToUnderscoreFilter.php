<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Zend\Filter\FilterChain;
use Zend\Filter\Word\DashToUnderscore;

class DashToUnderscoreFilter implements FilterInterface
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'dashToUnderscore';
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
