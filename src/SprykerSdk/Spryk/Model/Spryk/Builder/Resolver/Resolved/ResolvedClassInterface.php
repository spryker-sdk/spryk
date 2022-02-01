<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved;

use ReflectionClass;

interface ResolvedClassInterface extends ResolvedInterface
{
    /**
     * @param string $className
     *
     * @return void
     */
    public function setClassName(string $className): void;

    /**
     * @return string
     */
    public function getClassName(): string;

    /**
     * @param \ReflectionClass $reflectionClass
     *
     * @return void
     */
    public function setReflectionClass(ReflectionClass $reflectionClass): void;

    /**
     * @return \ReflectionClass
     */
    public function getReflectionClass(): ReflectionClass;

    /**
     * @param string $className
     *
     * @return void
     */
    public function setFullyQualifiedClassName(string $className): void;

    /**
     * @return string
     */
    public function getFullyQualifiedClassName(): string;

    /**
     * @param array $classTokenTree
     *
     * @return void
     */
    public function setClassTokenTree(array $classTokenTree): void;

    /**
     * @return array
     */
    public function getClassTokenTree(): array;

    /**
     * @param array $classTokenTree
     *
     * @return void
     */
    public function setOriginalClassTokenTree(array $classTokenTree): void;

    /**
     * @return array
     */
    public function getOriginalClassTokenTree(): array;

    /**
     * @param array $tokens
     *
     * @return void
     */
    public function setTokens(array $tokens): void;

    /**
     * @return array
     */
    public function getTokens(): array;
}
