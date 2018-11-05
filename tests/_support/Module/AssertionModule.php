<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Module;

use Codeception\Module;
use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Roave\BetterReflection\Reflection\ReflectionClassConstant;

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
                'Expected that class "%s" has method "%s" but method not found.',
                $className,
                $methodName
            )
        );
    }

    /**
     * @param string $className
     * @param string $value
     *
     * @return void
     */
    public function assertClassNotContains(string $className, string $value): void
    {
        $reflection = new BetterReflection();
        $classInfo = $reflection->classReflector()->reflect($className);

        $filePath = $classInfo->getLocatedSource()->getFileName();

        $this->assertNotRegExp('/' . preg_quote($value, '/') . '/', file_get_contents($filePath), sprintf('%s was not expected to be in the class, but was found.', $value));
    }

    /**
     * @param string $className
     * @param string $constantName
     * @param string $constantValue
     * @param string $visibility
     *
     * @return void
     */
    public function assertClassHasConstant(string $className, string $constantName, string $constantValue, string $visibility): void
    {
        $reflection = new BetterReflection();
        $classInfo = $reflection->classReflector()->reflect($className);

        $hasConstant = $classInfo->hasConstant($constantName);
        $this->assertTrue(
            $hasConstant,
            sprintf(
                'Expected that class "%s" has constant "%s" but constant not found.',
                $className,
                $constantName
            )
        );

        if ($hasConstant) {
            $constantReflection = $classInfo->getReflectionConstant($constantName);
            $constantVisibility = $this->getVisibilityFromConstantReflection($constantReflection);
            $this->assertSame(
                $visibility,
                $constantVisibility,
                sprintf(
                    'Expected that class constant "%s" visibility is "%s" but it is "%s".',
                    $constantName,
                    $visibility,
                    $constantVisibility
                )
            );
            $this->assertSame(
                $constantValue,
                $constantReflection->getValue(),
                sprintf(
                    'Expected that class constant "%s" value is "%s" but it is "%s".',
                    $constantName,
                    $constantValue,
                    $constantReflection->getValue()
                )
            );
        }
    }

    /**
     * @param \Roave\BetterReflection\Reflection\ReflectionClassConstant $reflectionClassConstant
     *
     * @return string|null
     */
    protected function getVisibilityFromConstantReflection(ReflectionClassConstant $reflectionClassConstant)
    {
        if ($reflectionClassConstant->isPublic()) {
            return 'public';
        }
        if ($reflectionClassConstant->isProtected()) {
            return 'protected';
        }
        if ($reflectionClassConstant->isPrivate()) {
            return 'private';
        }

        return null;
    }

    /**
     * @param string $className
     * @param string $methodName
     * @param string $expectBody
     *
     * @return void
     */
    public function assertMethodBody(string $className, string $methodName, string $expectBody): void
    {
        $this->assertClassHasMethod($className, $methodName);

        $reflection = new BetterReflection();
        $classInfo = $reflection->classReflector()->reflect($className);

        $methodBody = $classInfo->getMethod($methodName)->getBodyCode();
        $this->assertSame($expectBody, $methodBody);
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
     * @param \Roave\BetterReflection\Reflection\ReflectionClass $classInfo
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

    /**
     * @param int $count
     * @param string $pathToSchemaFile
     * @param string $tableName
     *
     * @return void
     */
    public function assertTableCount(int $count, string $pathToSchemaFile, string $tableName): void
    {
        static::assertFileExists($pathToSchemaFile, 'Expected schema file does not exists.');

        $simpleXmlElement = simplexml_load_file($pathToSchemaFile);

        if ($simpleXmlElement === false) {
            static::assertTrue($simpleXmlElement, 'Unable to load schema from file.');

            return;
        }

        $tableXmlElements = $simpleXmlElement->xpath('//table[@name="' . $tableName . '"]');

        if ($tableXmlElements === false) {
            static::assertTrue($tableXmlElements, 'Expected table not founf in schema.');

            return;
        }

        static::assertCount($count, $tableXmlElements, 'Expected table not found in schema.');
    }
}
