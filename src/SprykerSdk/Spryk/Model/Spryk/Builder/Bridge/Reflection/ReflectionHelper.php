<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection;

use PHPStan\BetterReflection\BetterReflection;
use PHPStan\BetterReflection\Reflection\ReflectionClass;
use SprykerSdk\Spryk\Exception\EmptyFileException;
use SprykerSdk\Spryk\Exception\ReflectionException;

class ReflectionHelper implements ReflectionHelperInterface
{
    /**
     * @param string $className
     *
     * @return \PHPStan\BetterReflection\Reflection\ReflectionClass
     */
    public function getReflectionClassByClassName(string $className): ReflectionClass
    {
        $betterReflection = new BetterReflection();

        return $betterReflection->classReflector()->reflect($className);
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\ReflectionException
     *
     * @return string
     */
    public function getFilePathByClassName(string $className): string
    {
        $targetReflection = $this->getReflectionClassByClassName($className);

        if ($targetReflection->getFileName() === null) {
            throw new ReflectionException('Filename is not expected to be null!');
        }

        return $targetReflection->getFileName();
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\EmptyFileException
     *
     * @return string
     */
    public function getFileContentByClassName(string $className): string
    {
        $targetFilePath = $this->getFilePathByClassName($className);
        $targetFileContent = file_get_contents($targetFilePath);

        if ($targetFileContent === false || strlen($targetFileContent) === 0) {
            throw new EmptyFileException(sprintf('Target file "%s" seems to be empty', $targetFilePath));
        }

        return $targetFileContent;
    }
}
