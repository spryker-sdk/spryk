<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor;

use PhpParser\BuilderFactory;
use PhpParser\Node;
use PhpParser\Node\Const_;
use PhpParser\Node\Expr;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\NodeVisitorAbstract;

class AddConstantVisitor extends NodeVisitorAbstract
{
 /**
  * @var string
  */
    protected string $constantName;

    /**
     * @var mixed
     */
    protected $constantValue;

    /**
     * @var string
     */
    protected string $modifier;

    /**
     * @param string $constantName
     * @param mixed $constantValue
     * @param string $modifier
     */
    public function __construct(string $constantName, $constantValue, string $modifier)
    {
        $this->constantName = $constantName;
        $this->constantValue = $constantValue;
        $this->modifier = $modifier;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node|int|null
     */
    public function enterNode(Node $node)
    {
        if (!($node instanceof Class_)) {
            return $node;
        }

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof ClassConst && $stmt->consts) {
                foreach ($stmt->consts as $const) {
                    if ($const->name->name === $this->constantName) {
                        return $node;
                    }
                }
            }
        }

        $node->stmts[] = $this->createConst();

        return $node;
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassConst
     */
    protected function createConst(): ClassConst
    {
        switch ($this->modifier) {
            case 'protected':
                $modifier = Class_::MODIFIER_PROTECTED;

                break;
            case 'private':
                $modifier = Class_::MODIFIER_PRIVATE;

                break;
            default:
                $modifier = Class_::MODIFIER_PUBLIC;
        }

        return (new ClassConst([new Const_($this->constantName, $this->prepareValue())], $modifier));
    }

    /**
     * @return \PhpParser\Node\Expr
     */
    protected function prepareValue(): Expr
    {
        return (new BuilderFactory())->val($this->constantValue);
    }
}
