<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
