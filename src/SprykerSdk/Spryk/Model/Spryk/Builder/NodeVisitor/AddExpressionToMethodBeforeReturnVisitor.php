<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Expression;
use PhpParser\Node\Stmt\Return_;
use PhpParser\NodeVisitorAbstract;

class AddExpressionToMethodBeforeReturnVisitor extends NodeVisitorAbstract
{
    /**
     * @var \PhpParser\Node\Stmt\Expression
     */
    protected Expression $expressionNode;

    /**
     * @var string
     */
    protected string $methodName;

    /**
     * @param \PhpParser\Node\Stmt\Expression $expressionNode
     * @param string $methodName
     */
    public function __construct(Expression $expressionNode, string $methodName)
    {
        $this->expressionNode = $expressionNode;
        $this->methodName = $methodName;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node|array|int|null
     */
    public function enterNode(Node $node)
    {
        if (!($node instanceof ClassMethod)) {
            return $node;
        }

        if ((string)$node->name !== $this->methodName) {
            return $node;
        }

        $stmts = $node->stmts;

        if (!$stmts) {
            return $node;
        }

        $newStatements = [];

        foreach ($stmts as $stmt) {
            if ($stmt instanceof Return_) {
                $newStatements[] = $this->expressionNode;
            }
            $newStatements[] = $stmt;
        }

        $node->stmts = $newStatements;

        return $node;
    }
}
