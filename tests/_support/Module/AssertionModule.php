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
                'Expected that class "%s" has method "%s" but method not found.',
                $className,
                $methodName
            )
        );
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

        self::assertCount($count, $tableXmlElements, 'Expected table not found in schema.');
    }
}
