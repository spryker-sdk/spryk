<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use Doctrine\Inflector\InflectorFactory;

/**
 * Filter is used to convert a word in plural form
 * into a word in singular form.
 *
 * Example:
 * $this->filter(`products') === 'product';
 */
class SingularizeFilter implements FilterInterface
{
    /**
     * @var string
     */
    protected const FILTER_NAME = 'singularize';

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
        $inflector = InflectorFactory::create()->build();

        return $inflector->singularize($value);
    }
}
