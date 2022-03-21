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
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddExpressionToMethodBeforeReturnVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\SprykConfig;

class ResourceRouteSpryk extends AbstractBuilder
{
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
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     * @param \PhpParser\Parser $parser
     * @param \PhpParser\Lexer $lexer
     */
    public function __construct(
        SprykConfig $config,
        FileResolverInterface $fileResolver,
        TemplateRendererInterface $renderer,
        NodeFinderInterface $nodeFinder,
        Parser $parser,
        Lexer $lexer
    ) {
        parent::__construct($config, $fileResolver);

        $this->renderer = $renderer;
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
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        return !$this->isRouteDeclared();
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolved */
        $resolved = $this->fileResolver->resolve($this->getTarget());

        if (!$resolved) {
            return;
        }

        $expression = $this->getExpression();

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new AddExpressionToMethodBeforeReturnVisitor($expression, 'configure'));
        $newStmts = $traverser->traverse($resolved->getClassTokenTree());

        $resolved->setClassTokenTree($newStmts);

        $this->log(
            sprintf(
                'Added resource route declaration to "%s".',
                $this->getTarget(),
            ),
        );
    }

    /**
     * @return \PhpParser\Node\Stmt\Expression
     */
    protected function getExpression(): Expression
    {
        $templateName = $this->getTemplateName();

        $methodContent = sprintf('<?php %s', $this->renderer->render(
            $templateName,
            $this->arguments->getArguments(),
        ));

        /** @var array<\PhpParser\Node\Stmt> $expressions */
        $expressions = $this->parser->parse($methodContent);

        /** @var \PhpParser\Node\Stmt\Expression $expression */
        $expression = $expressions[0];

        return $expression;
    }

    /**
     * @return string
     */
    protected function getTemplateName(): string
    {
        return $this->getStringArgument(static::ARGUMENT_TEMPLATE);
    }

    /**
     * @return bool
     */
    protected function isRouteDeclared(): bool
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolved */
        $resolved = $this->fileResolver->resolve($this->getTarget());

        if (!$resolved) {
            return false;
        }

        $resourceRouteMethod = $this->getResourceRouteMethod();
        $methodCallName = sprintf('add%s', ucfirst($resourceRouteMethod));

        $methodCallNode = $this->nodeFinder->findMethodCallNode($resolved->getClassTokenTree(), $methodCallName);

        if ($methodCallNode) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getResourceRouteMethod(): string
    {
        return $this->getStringArgument(static::ARGUMENT_RESOURCE_ROUTE_METHOD);
    }
}
