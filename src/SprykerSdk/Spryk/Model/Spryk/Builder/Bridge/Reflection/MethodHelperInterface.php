<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection;

use Roave\BetterReflection\Reflection\ReflectionMethod;

interface MethodHelperInterface
{
    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getMethodReturnType(ReflectionMethod $reflectionMethod): string;

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getParameter(ReflectionMethod $reflectionMethod): string;

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getParameterNames(ReflectionMethod $reflectionMethod): string;
}
