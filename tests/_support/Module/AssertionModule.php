<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\PrettyPrinter\Standard;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;

class AssertionModule extends Module
{
 /**
  * @return \SprykerSdkTest\Module\SprykHelper
  */
    protected function getSprykHelper(): SprykHelper
    {
        /** @var \SprykerSdkTest\Module\SprykHelper $sprykHelper */
        $sprykHelper = $this->getModule(SprykHelper::class);

        return $sprykHelper;
    }

    /**
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    public function assertClassHasMethod(string $className, string $methodName): void
    {
        $resolved = $this->getResolvedByClassName($className);
        $nodeFinder = $this->getNodeFinder();

        $method = $nodeFinder->findMethodNode($resolved->getClassTokenTree(), $methodName);

        $this->assertInstanceOf(
            ClassMethod::class,
            $method,
            sprintf(
                'Expected that class "%s" has method "%s" but method not found.',
                $className,
                $methodName,
            ),
        );
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
        $resolved = $this->getResolvedByClassName($className);
        $classConst = $this->getNodeFinder()->findConstantNode($resolved->getClassTokenTree(), $constantName);

        $this->assertInstanceOf(
            ClassConst::class,
            $classConst,
            sprintf(
                'Expected that class "%s" has constant "%s" but constant not found.',
                $className,
                $constantName,
            ),
        );

        $constantVisibility = $this->getVisibilityFromClassConst($classConst);

        $this->assertSame(
            $visibility,
            $constantVisibility,
            sprintf(
                'Expected that class constant "%s" visibility is "%s" but it is "%s".',
                $constantName,
                $visibility,
                $constantVisibility,
            ),
        );

        $classConstValue = $classConst->consts[0]->value->value;

        $this->assertSame(
            $constantValue,
            $classConstValue,
            sprintf(
                'Expected that class constant "%s" value is "%s" but it is "%s".',
                $constantName,
                $constantValue,
                $classConstValue,
            ),
        );
    }

    /**
     * @param \PhpParser\Node\Stmt\ClassConst $classConst
     *
     * @return string|null
     */
    protected function getVisibilityFromClassConst(ClassConst $classConst): ?string
    {
        if ($classConst->isPublic()) {
            return 'public';
        }
        if ($classConst->isProtected()) {
            return 'protected';
        }
        if ($classConst->isPrivate()) {
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
        $resolved = $this->getResolvedByClassName($className);
        $classMethod = $this->getNodeFinder()->findMethodNode($resolved->getClassTokenTree(), $methodName);

        $printer = new Standard();
        $methodBodyCode = $printer->prettyPrint($classMethod->stmts);

        $this->assertSame($expectBody, $methodBodyCode);
    }

    /**
     * @param string $className
     * @param string $resourceRouteMethod
     *
     * @return void
     */
    public function assertRouteAdded(string $className, string $resourceRouteMethod): void
    {
        $resolved = $this->getResolvedByClassName($className);
        $methodCallNode = $this->getNodeFinder()->findMethodCallNode($resolved->getClassTokenTree(), $resourceRouteMethod);

        $this->assertInstanceOf(MethodCall::class, $methodCallNode, sprintf('Expected to find a method call "%s::%s" but was not found.', $className, $resourceRouteMethod));
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
        $resolved = $this->getResolvedByClassName($className);
        $nodeFinder = $this->getNodeFinder();

        $method = $nodeFinder->findMethodNode($resolved->getClassTokenTree(), $methodName);

        if (!$method) {
            $this->assertTrue(false, sprintf('Could not find a method by name "%s"', $methodName));
        }

        $docBlock = $method->getDocComment()->getText();
        $this->assertSame($expectedDocBlock, $docBlock);
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface
     */
    protected function getNodeFinder(): NodeFinderInterface
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder */
        $nodeFinder = $this->getSprykHelper()->getClass(NodeFinderInterface::class);

        return $nodeFinder;
    }

    /**
     * @param string $className
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface
     */
    protected function getResolvedByClassName(string $className): ResolvedClassInterface
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolved */
        $resolved = $this->getSprykHelper()->getFileResolver()->resolve($className);

        $this->assertInstanceOf(ResolvedClassInterface::class, $resolved, sprintf('Expected class "%s" not found.', $className));

        return $resolved;
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
        $this->assertFileExists($pathToSchemaFile, 'Expected schema file does not exists.');

        $simpleXmlElement = simplexml_load_file($pathToSchemaFile);

        if ($simpleXmlElement === false) {
            $this->assertTrue($simpleXmlElement, 'Unable to load schema from file.');

            return;
        }

        $tableXmlElements = $simpleXmlElement->xpath('//table[@name="' . $tableName . '"]');

        if ($tableXmlElements === false) {
            $this->assertTrue($tableXmlElements, 'Expected table not found in schema.');

            return;
        }

        $this->assertCount($count, $tableXmlElements, 'Expected table not found in schema.');
    }
}
