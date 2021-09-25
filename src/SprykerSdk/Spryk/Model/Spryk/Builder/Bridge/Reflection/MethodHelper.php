<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection;

use PHPStan\BetterReflection\Reflection\ReflectionMethod;
use PHPStan\BetterReflection\Reflection\ReflectionParameter;
use PHPStan\BetterReflection\Reflection\ReflectionType;

class MethodHelper implements MethodHelperInterface
{
    /**
     * @var string
     */
    protected const NULLABLE_RETURN_TYPE_HINT = ': ?';
    /**
     * @var string
     */
    protected const NON_NULLABLE_RETURN_TYPE_HINT = ': ';

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getMethodReturnType(ReflectionMethod $reflectionMethod): string
    {
        $reflectionType = $reflectionMethod->getReturnType();
        if ($reflectionType === null) {
            return '';
        }

        return $this->buildMethodReturnTypeFromReflectionType($reflectionType);
    }

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionType $reflectionType
     *
     * @return string
     */
    protected function buildMethodReturnTypeFromReflectionType(ReflectionType $reflectionType): string
    {
        $returnType = ($reflectionType->allowsNull()) ? static::NULLABLE_RETURN_TYPE_HINT : static::NON_NULLABLE_RETURN_TYPE_HINT;

        /** @var \PHPStan\BetterReflection\Reflection\ReflectionNamedType $reflectionType */
        if (!$reflectionType->isBuiltin()) {
            $returnType .= '\\';
        }

        return $returnType . $reflectionType;
    }

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getParameter(ReflectionMethod $reflectionMethod): string
    {
        $parameters = [];

        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $parameters[] = $this->buildParameter($reflectionParameter);
        }

        return implode(', ', $parameters);
    }

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionParameter $reflectionParameter
     *
     * @return string
     */
    protected function buildParameter(ReflectionParameter $reflectionParameter): string
    {
        $parameter = '';

        if ($this->isNullable($reflectionParameter)) {
            $parameter .= '?';
        }

        if ($reflectionParameter->hasType() && $reflectionParameter->getType() !== null) {
            /** @var \PHPStan\BetterReflection\Reflection\ReflectionNamedType $reflectionType */
            $reflectionType = $reflectionParameter->getType();
            if (!$reflectionType->isBuiltin()) {
                $parameter .= '\\';
            }
            $parameter .= $reflectionType . ' ';
        }

        $parameter .= '$' . $reflectionParameter->getName();
        $parameter .= $this->addDefaultValue($reflectionParameter);

        return $parameter;
    }

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionParameter $reflectionParameter
     *
     * @return bool
     */
    protected function isNullable(ReflectionParameter $reflectionParameter): bool
    {
        if ($reflectionParameter->hasType() && $reflectionParameter->isDefaultValueAvailable() && $reflectionParameter->getDefaultValue() === null) {
            return true;
        }

        return false;
    }

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionParameter $reflectionParameter
     *
     * @return string
     */
    protected function addDefaultValue(ReflectionParameter $reflectionParameter): string
    {
        $parameter = '';
        if (!$reflectionParameter->isDefaultValueAvailable()) {
            return $parameter;
        }

        $parameter .= ' = ';

        if ($reflectionParameter->getDefaultValue() === null) {
            $parameter .= 'null';
        }

        if (!is_array($reflectionParameter->getDefaultValue())) {
            $parameter .= $reflectionParameter->getDefaultValue();
        }

        if (is_array($reflectionParameter->getDefaultValue())) {
            $parameter .= '[]';
        }

        return $parameter;
    }

    /**
     * @param \PHPStan\BetterReflection\Reflection\ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getParameterNames(ReflectionMethod $reflectionMethod): string
    {
        $parameters = [];
        foreach ($reflectionMethod->getParameters() as $reflectionParameter) {
            $parameters[] = '$' . $reflectionParameter->getName();
        }

        return implode(', ', $parameters);
    }
}
