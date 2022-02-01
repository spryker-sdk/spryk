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
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddExpressionToMethodBeforeReturnVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class DependencyProviderSpryk implements SprykBuilderInterface
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
        return !$this->isDependencyDeclared($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetArgument($sprykDefinition));

        $expression = $this->getExpression($sprykDefinition);

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new AddExpressionToMethodBeforeReturnVisitor($expression, $this->getProvideMethodArgument($sprykDefinition)));
        $newStmts = $traverser->traverse($resolved->getClassTokenTree());

        $resolved->setClassTokenTree($newStmts);

        $style->report(
            sprintf(
                'Added provided dependency "%s" to container.',
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

        $expressionContent = sprintf('<?php %s', $this->renderer->render(
            $templateName,
            $argumentCollection->getArguments(),
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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isDependencyDeclared(SprykDefinitionInterface $sprykDefinition): bool
    {
        $addProvideMethodName = $this->getAddProvideMethodName($sprykDefinition);

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetArgument($sprykDefinition));
        $methodCallNode = $this->nodeFinder->findMethodCallNode($resolved->getClassTokenTree(), $addProvideMethodName);

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
    protected function getProvideMethodArgument(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_PROVIDE_METHOD)
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
     * @return string
     */
    protected function getAddProvideMethodName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_PROVIDER_METHOD)
            ->getValue();
    }
}
