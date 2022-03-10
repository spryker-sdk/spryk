<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection;

use ReflectionClass;

interface ReflectionHelperInterface
{
    /**
     * @param class-string|string $className
     *
     * @return \ReflectionClass
     */
    public function getReflectionClassByClassName(string $className): ReflectionClass;

    /**
     * @param class-string|string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\ReflectionException
     *
     * @return string
     */
    public function getFilePathByClassName(string $className): string;

    /**
     * @param class-string|string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\EmptyFileException
     *
     * @return string
     */
    public function getFileContentByClassName(string $className): string;
}
