<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

use ReflectionClass;

class ResolvedClass extends AbstractResolved implements ResolvedClassInterface
{
    /**
     * @var string
     */
    protected string $className;

    /**
     * @var \ReflectionClass
     */
    protected \ReflectionClass $reflectionClass;

    /**
     * @var string
     */
    protected string $fullyQualifiedClassName;

    /**
     * @var array
     */
    protected array $classTokenTree;

    /**
     * @var array
     */
    protected array $originalClassTokenTree;

    /**
     * @var array
     */
    protected array $tokens;

    /**
     * @param string $className
     *
     * @return void
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return string
     */
    public function getClassName(): string
    {
        return $this->className;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return void
     */
    public function setReflectionClass(ReflectionClass $reflectionClass): void
    {
        $this->reflectionClass = $reflectionClass;
    }

    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass(): ReflectionClass
    {
        return $this->reflectionClass;
    }

    /**
     * @param string $className
     *
     * @return void
     */
    public function setFullyQualifiedClassName(string $className): void
    {
        $this->fullyQualifiedClassName = $className;
    }

    /**
     * @return string
     */
    public function getFullyQualifiedClassName(): string
    {
        return $this->fullyQualifiedClassName;
    }

    /**
     * @param array $classTokenTree
     *
     * @return void
     */
    public function setClassTokenTree(array $classTokenTree): void
    {
        $this->classTokenTree = $classTokenTree;
    }

    /**
     * @return array
     */
    public function getClassTokenTree(): array
    {
        return $this->classTokenTree;
    }

    /**
     * @param array $classTokenTree
     *
     * @return void
     */
    public function setOriginalClassTokenTree(array $classTokenTree): void
    {
        $this->originalClassTokenTree = $classTokenTree;
    }

    /**
     * @return array
     */
    public function getOriginalClassTokenTree(): array
    {
        return $this->originalClassTokenTree;
    }

    /**
     * @param array $tokens
     *
     * @return void
     */
    public function setTokens(array $tokens): void
    {
        $this->tokens = $tokens;
    }

    /**
     * @return array
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }
}
