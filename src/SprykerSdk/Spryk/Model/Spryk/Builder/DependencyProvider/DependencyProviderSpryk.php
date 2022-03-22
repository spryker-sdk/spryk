<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\DependencyProvider;

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

class DependencyProviderSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    protected const ARGUMENT_TEMPLATE = 'template';

    /**
     * The DependencyProvider method where the addX method should be added to
     *
     * @var string
     */
    protected const ARGUMENT_PROVIDE_METHOD = 'provideMethod';

    /**
     * The addX method
     *
     * @var string
     */
    protected const ARGUMENT_PROVIDER_METHOD = 'providerMethod';

    /**
     * @var string
     */
    protected const SPRYK_NAME = 'dependencyProvider';

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
        return !$this->isDependencyDeclared();
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTarget());

        $expression = $this->getExpression();

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new AddExpressionToMethodBeforeReturnVisitor($expression, $this->getProvideMethodArgument()));
        $newStmts = $traverser->traverse($resolved->getClassTokenTree());

        $resolved->setClassTokenTree($newStmts);

        $this->log(
            sprintf(
                'Added provided dependency "%s" to container.',
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

        $expressionContent = sprintf('<?php %s', $this->renderer->render(
            $templateName,
            $this->arguments->getArguments(),
        ));

        /** @var array<\PhpParser\Node\Stmt> $expressions */
        $expressions = $this->parser->parse($expressionContent);

        /** @var \PhpParser\Node\Stmt\Expression $expression */
        $expression = $expressions[0];

        return $expression;
    }

    /**
     * Find out if the DependencyProvider already calls the `add*` method inside of the `provideDependencies` method.
     *
     * @return bool
     */
    protected function isDependencyDeclared(): bool
    {
        $addProvideMethodName = $this->getAddProvideMethodName();

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTarget());
        $methodCallNode = $this->nodeFinder->findMethodCallNode($resolved->getClassTokenTree(), $addProvideMethodName);

        if ($methodCallNode) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    protected function getProvideMethodArgument(): string
    {
        return $this->getStringArgument(static::ARGUMENT_PROVIDE_METHOD);
    }

    /**
     * @return string
     */
    protected function getTemplateName(): string
    {
        return $this->getStringArgument(static::ARGUMENT_TEMPLATE);
    }

    /**
     * @return string
     */
    protected function getAddProvideMethodName(): string
    {
        return $this->getStringArgument(static::ARGUMENT_PROVIDER_METHOD);
    }
}
