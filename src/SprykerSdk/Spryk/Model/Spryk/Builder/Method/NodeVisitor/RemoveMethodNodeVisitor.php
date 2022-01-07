<?php

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Method\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Nop;
use PhpParser\NodeVisitorAbstract;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class RemoveMethodNodeVisitor extends NodeVisitorAbstract
{
    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $methodName;

    /**
     * @var SprykStyleInterface
     */
    protected SprykStyleInterface $style;

    /**
     * @param string $name
     * @param string $methodName
     * @param SprykStyleInterface $style
     */
    public function __construct(string $name, string $methodName, SprykStyleInterface $style)
    {
        $this->name = $name;
        $this->methodName = $methodName;
        $this->style = $style;
    }

    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node\Stmt\Nop|void
     */
    public function leaveNode(Node $node)
    {
        if ($node instanceof ClassMethod && (string)$node->name === $this->methodName) {
            $this->style->writeln(sprintf('Removed method "<fg=yellow>%s</>" in "<fg=yellow>%s</>"', $this->methodName, $this->name));

            return new Nop();
        }
    }
}
