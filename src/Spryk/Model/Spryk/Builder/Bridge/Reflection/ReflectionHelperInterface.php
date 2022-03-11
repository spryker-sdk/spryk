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
     * @phpstan-param class-string $className
     *
     * @param string $className
     *
     * @return \ReflectionClass
     */
    public function getReflectionClassByClassName(string $className): ReflectionClass;

    /**
     * @phpstan-param class-string $className
     *
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\ReflectionException
     *
     * @return string
     */
    public function getFilePathByClassName(string $className): string;

    /**
     * @phpstan-param class-string $className
     *
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\EmptyFileException
     *
     * @return string
     */
    public function getFileContentByClassName(string $className): string;
}
