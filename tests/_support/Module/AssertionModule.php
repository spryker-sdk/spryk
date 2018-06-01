<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Module;

use Codeception\Module;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionClass;

class AssertionModule extends Module
{
    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    public function assertClassHasMethod(string $className, string $methodName): void
    {
        $reflection = new BetterReflection();
        $classInfo = $reflection->classReflector()->reflect($className);

        $this->assertTrue(
            $classInfo->hasMethod($methodName),
            sprintf(
                'Expected that class "%s" has method "%s" but method not found. Existing method(s): %s.',
                $className,
                $methodName,
                implode(' ,', $this->getClassMethodNames($classInfo))
            )
        );
    }

    /**
     * @param string $expectedDocBlock
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    public function assertDocBlockForClassMethod(string $expectedDocBlock, string $className, string $methodName): void
    {
        $betterReflection = new BetterReflection();
        $reflectedClass = $betterReflection->classReflector()
            ->reflect($className);

        $reflectedMethod = $reflectedClass->getMethod($methodName);
        $docBlock = $reflectedMethod->getDocComment();
        $this->assertSame($expectedDocBlock, $docBlock);
    }

    /**
     * @param \Roave\BetterReflection\Reflection\Reflection|\Roave\BetterReflection\Reflection\ReflectionClass $classInfo
     *
     * @return string[]
     */
    protected function getClassMethodNames(ReflectionClass $classInfo): array
    {
        $classMethods = $classInfo->getMethods();
        $classMethodNames = [];

        foreach ($classMethods as $classMethod) {
            $classMethodNames[] = $classMethod->getName();
        }

        return $classMethodNames;
    }
}
