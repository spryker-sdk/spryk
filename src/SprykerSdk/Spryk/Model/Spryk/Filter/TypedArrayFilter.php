<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

class TypedArrayFilter implements FilterInterface
{
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
        $filteredParameters = [];

        foreach ($initialParameters as $parameter) {
            $parameterExploded = explode(' ', $parameter);
            if (count($parameterExploded) > 2) {
                $filteredParameters[] = $parameter;
                continue;
            }

            if ($this->isTypedArray($parameterExploded[0])) {
                $parameter = isset($parameterExploded[1])
                    ? implode(' ', ['array', $parameterExploded[1]])
                    : 'array';
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
}
