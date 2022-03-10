<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection;

use ReflectionMethod;

interface MethodHelperInterface
{
    /**
     * @param \ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getMethodReturnType(ReflectionMethod $reflectionMethod): string;

    /**
     * @param \ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getParameter(ReflectionMethod $reflectionMethod): string;

    /**
     * @param \ReflectionMethod $reflectionMethod
     *
     * @return string
     */
    public function getParameterNames(ReflectionMethod $reflectionMethod): string;
}
