<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
