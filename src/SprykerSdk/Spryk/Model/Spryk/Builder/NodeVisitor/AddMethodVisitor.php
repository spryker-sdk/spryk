<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Interface_;
use PhpParser\NodeVisitorAbstract;

class AddMethodVisitor extends NodeVisitorAbstract
{
    /**
     * @var \PhpParser\Node\Stmt\ClassMethod
     */
    protected ClassMethod $classMethodNode;

    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethodNode
     */
    public function __construct(ClassMethod $classMethodNode)
    {
        $this->classMethodNode = $classMethodNode;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node|array|int|null
     */
    public function enterNode(Node $node)
    {
        if (!($node instanceof Class_) && !($node instanceof Interface_)) {
            return $node;
        }

        $stmts = $node->stmts;
        $stmts[] = $this->classMethodNode;
        $node->stmts = $stmts;

        return $node;
    }
}
