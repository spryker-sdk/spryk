<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

/**
 * Filter is used to convert a string
 * representing any type-hinted array into an argument description.
 *
 * Example:
 * $this->filter(`\Organization\Module\Class[] $classes') === 'array $classes';
 * $this->filter(`array $classes') === 'array $classes';
 */
class TypedArrayFilter implements FilterInterface
{
    /**
     * @var string
     */
    protected const FILTER_NAME = 'typedArrayConvert';

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
        $initialParameters = preg_split('/(\s*,*\s*)*,+(\s*,*\s*)*/', $value);
        if (!is_array($initialParameters)) {
            return $value;
        }

        $filteredParameters = [];
        foreach ($initialParameters as $parameter) {
            $parameterExploded = explode(' ', $parameter, 2);
            if ($this->isTypedArray($parameterExploded[0])) {
                $parameterExploded[0] = $this->convertToArrayTypeHint($parameterExploded[0]);
                $parameter = count($parameterExploded) > 1
                    ? implode(' ', $parameterExploded)
                    : $parameterExploded[0];
            }

            $filteredParameters[] = $parameter;
        }

        return implode(', ', $filteredParameters);
    }

    /**
     * @param string $value
     *
     * @return bool
     */
    protected function isTypedArray(string $value): bool
    {
        return (bool)preg_match('((.*?)\[\]$)', $value);
    }

    /**
     * @param string $typedArray
     *
     * @return string
     */
    protected function convertToArrayTypeHint(string $typedArray): string
    {
        return (strpos($typedArray, '?') === 0 ? '?' : '') . 'array';
    }
}
