<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\ResourceRoute;

use PhpParser\Lexer;
use PhpParser\Node\Stmt\Expression;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddExpressionToMethodBeforeReturnVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class ResourceRouteSpryk implements SprykBuilderInterface
{
    /**
     * @var string
     */
    protected const ARGUMENT_TARGET = 'target';

    /**
     * @var string
     */
    protected const ARGUMENT_TEMPLATE = 'template';

    /**
     * @var string
     */
    protected const TARGET_METHOD_NAME = 'configure';

    /**
     * @var string
     */
    protected const ARGUMENT_RESOURCE_ROUTE_METHOD = 'resourceRouteMethod';

    /**
     * @var string
     */
    protected const SPRYK_NAME = 'resourceRoute';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected TemplateRendererInterface $renderer;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface
     */
    protected FileResolverInterface $fileResolver;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface
     */
    protected NodeFinderInterface $nodeFinder;

    /**
     * @var \PhpParser\Parser
     */
    protected Parser $parser;

    /**
     * @var \PhpParser\Lexer
     */
    protected Lexer $lexer;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     * @param \PhpParser\Parser $parser
     * @param \PhpParser\Lexer $lexer
     */
    public function __construct(
        TemplateRendererInterface $renderer,
        FileResolverInterface $fileResolver,
        NodeFinderInterface $nodeFinder,
        Parser $parser,
        Lexer $lexer
    ) {
        $this->renderer = $renderer;
        $this->fileResolver = $fileResolver;
        $this->nodeFinder = $nodeFinder;
        $this->parser = $parser;
        $this->lexer = $lexer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::SPRYK_NAME;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return !$this->isRouteDeclared($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetArgument($sprykDefinition));

        if (!$resolved) {
            return;
        }

        $expression = $this->getExpression($sprykDefinition);

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new AddExpressionToMethodBeforeReturnVisitor($expression, 'configure'));
        $newStmts = $traverser->traverse($resolved->getClassTokenTree());

        $resolved->setClassTokenTree($newStmts);

        $style->report(
            sprintf(
                'Added resource route declaration to "%s".',
                $this->getTargetArgument($sprykDefinition),
            ),
        );
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \PhpParser\Node\Stmt\Expression
     */
    protected function getExpression(SprykDefinitionInterface $sprykDefinition): Expression
    {
        $argumentCollection = $sprykDefinition->getArgumentCollection();
        $templateName = $this->getTemplateName($sprykDefinition);

        $methodContent = sprintf('<?php %s', $this->renderer->render(
            $templateName,
            $argumentCollection->getArguments(),
        ));

        /** @var array<\PhpParser\Node\Stmt> $expressions */
        $expressions = $this->parser->parse($methodContent);

        /** @var \PhpParser\Node\Stmt\Expression $expression */
        $expression = $expressions[0];

        return $expression;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetArgument(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTemplateName(SprykDefinitionInterface $sprykDefinition): string
    {
        $templateName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TEMPLATE)
            ->getValue();

        return $templateName;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isRouteDeclared(SprykDefinitionInterface $sprykDefinition): bool
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetArgument($sprykDefinition));

        if (!$resolved) {
            return false;
        }

        $resourceRouteMethod = $this->getResourceRouteMethod($sprykDefinition);
        $methodCallName = sprintf('add%s', ucfirst($resourceRouteMethod));

        $methodCallNode = $this->nodeFinder->findMethodCallNode($resolved->getClassTokenTree(), $methodCallName);

        if ($methodCallNode) {
            return true;
        }

        return false;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getResourceRouteMethod(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_RESOURCE_ROUTE_METHOD)
            ->getValue();
    }
}
