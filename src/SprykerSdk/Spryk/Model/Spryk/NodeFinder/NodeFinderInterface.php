<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\NodeFinder;

use PhpParser\Node\Expr\MethodCall;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;

interface NodeFinderInterface
{
    /**
     * @param array<\PhpParser\Node\Stmt> $tokens
     * @param string $methodName
     *
     * @return \PhpParser\Node\Stmt\ClassMethod|null
     */
    public function findMethodNode(array $tokens, string $methodName): ?ClassMethod;

    /**
     * @param array<\PhpParser\Node\Stmt> $tokens
     * @param string $methodName
     *
     * @return \PhpParser\Node\Expr\MethodCall|null
     */
    public function findMethodCallNode(array $tokens, string $methodName): ?MethodCall;

    /**
     * @param array<\PhpParser\Node\Stmt> $tokens
     *
     * @return array
     */
    public function findMethods(array $tokens): array;

    /**
     * @param array<\PhpParser\Node\Stmt> $tokens
     *
     * @return array
     */
    public function findMethodNames(array $tokens): array;

    /**
     * @param array<\PhpParser\Node\Stmt> $tokens
     * @param string $constantName
     *
     * @return \PhpParser\Node\Stmt\ClassConst|null
     */
    public function findConstantNode(array $tokens, string $constantName): ?ClassConst;

    /**
     * @param array<\PhpParser\Node\Stmt> $tokens
     *
     * @return string|null
     */
    public function findClassOrInterfaceName(array $tokens): ?string;
}
