<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to add the `Mapper` suffix to a string
 * if it is not present in the given one.
 *
 * Example:
 * $this->filter('Product') === `ProductMapper';
 * $this->filter('CategoryMapper') === `CategoryMapper';
 */
class EnsureMapperSuffixFilter implements FilterInterface
{
    /**
     * @var string
     */
    public const MAPPER_SUFFIX = 'Mapper';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'ensureMapperSuffix';
    }

    /**
     * @param string $value
     *
     * @return string
     */
    public function filter(string $value): string
    {
        if (mb_substr($value, - mb_strlen(static::MAPPER_SUFFIX)) !== static::MAPPER_SUFFIX) {
            $value = $value . static::MAPPER_SUFFIX;
        }

        return ucfirst($value);
    }
}
