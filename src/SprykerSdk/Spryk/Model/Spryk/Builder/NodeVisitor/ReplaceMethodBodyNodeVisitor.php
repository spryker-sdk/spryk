<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeVisitorAbstract;

class ReplaceMethodBodyNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var string
     */
    protected string $methodName;

    /**
     * @var \PhpParser\Node\Stmt\ClassMethod
     */
    protected ClassMethod $classMethod;

    /**
     * @param string $methodName
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     */
    public function __construct(string $methodName, ClassMethod $classMethod)
    {
        $this->methodName = $methodName;
        $this->classMethod = $classMethod;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node\Stmt\ClassMethod|void
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassMethod && (string)$node->name === $this->methodName) {
            $node->stmts = $this->classMethod->stmts;

            return $node;
        }
    }
}
