<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection;

use Roave\BetterReflection\Reflection\ReflectionClass;

interface ReflectionHelperInterface
{
    /**
     * @param string $className
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionClass
     */
    public function getReflectionClassByClassName(string $className): ReflectionClass;

    /**
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\ReflectionException
     *
     * @return string
     */
    public function getFilePathByClassName(string $className): string;

    /**
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\EmptyFileException
     *
     * @return string
     */
    public function getFileContentByClassName(string $className): string;
}
