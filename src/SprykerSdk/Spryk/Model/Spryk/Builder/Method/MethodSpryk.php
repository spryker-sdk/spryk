<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Method;

use PhpParser\Lexer;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use SprykerSdk\Spryk\Exception\ArgumentNotFoundException;
use SprykerSdk\Spryk\Exception\NotAFullyQualifiedClassNameException;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddMethodVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\ReplaceMethodBodyNodeVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class MethodSpryk implements SprykBuilderInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_TARGET = 'target';

    /**
     * @var string
     */
    public const ARGUMENT_TEMPLATE = 'template';

    /**
     * @var string
     */
    public const ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN = 'fqcnPattern';

    /**
     * @var array
     */
    public const ARGUMENT_METHOD_NAME_CANDIDATES = [
        'method',
        'controllerMethod',
        'factoryMethod',
        'dependencyMethod',
        'provideMethod',
        'facadeMethod',
        'modelMethod',
        'providerMethod',
        'clientMethod',
        'configMethod',
        'entityManagerMethod',
        'repositoryMethod',
    ];

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
        return 'method';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        $methodName = $this->getMethodName($sprykDefinition);

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolvedClass */
        $resolvedClass = $this->fileResolver->resolve($this->getTargetClassName($sprykDefinition));

        $methodExists = $this->methodExists($resolvedClass, $methodName);

        if (!$methodExists) {
            return true;
        }

        if ($sprykDefinition->getArgumentCollection()->hasArgument('allowOverride')) {
            return (bool)$sprykDefinition->getArgumentCollection()->getArgument('allowOverride')->getValue();
        }

        return false;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolvedClass */
        $resolvedClass = $this->fileResolver->resolve($this->getTargetClassName($sprykDefinition));
        $methodName = $this->getMethodName($sprykDefinition);
        $methodExists = $this->methodExists($resolvedClass, $methodName);
        $argumentCollection = $sprykDefinition->getArgumentCollection();
        $methodArgument = new Argument();
        $methodArgument
            ->setName('method')
            ->setValue($methodName);

        $argumentCollection->addArgument($methodArgument);

        $classMethodNode = $this->getClassMethodNode($sprykDefinition);

        if ($argumentCollection->hasArgument('allowOverride') && $argumentCollection->getArgument('allowOverride')->getValue() && $methodExists) {
            $traverser = new NodeTraverser();
            $traverser->addVisitor(new ReplaceMethodBodyNodeVisitor($methodName, $classMethodNode));

            $newStmts = $traverser->traverse($resolvedClass->getClassTokenTree());

            $resolvedClass->setClassTokenTree($newStmts);

            return;
        }

        $traverser = new NodeTraverser();
        $traverser->addVisitor(new AddMethodVisitor($classMethodNode));
        $newStmts = $traverser->traverse($resolvedClass->getClassTokenTree());

        $resolvedClass->setClassTokenTree($newStmts);

        $style->report(sprintf(
            'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
            $this->getMethodName($sprykDefinition),
            $argumentCollection->getArgument('target'),
        ));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function getClassMethodNode(SprykDefinitionInterface $sprykDefinition): ClassMethod
    {
        $argumentCollection = $sprykDefinition->getArgumentCollection();
        $templateName = $this->getTemplateName($sprykDefinition);

        $methodContent = sprintf('<?php class Foo {%s}', $this->renderer->render(
            $templateName,
            $argumentCollection->getArguments(),
        ));

        /** @var array<\PhpParser\Node\Stmt> $methodContentToken */
        $methodContentToken = $this->parser->parse($methodContent);

        /** @var \PhpParser\Node\Stmt\Class_ $classStmt */
        $classStmt = $methodContentToken[0];

        /** @var \PhpParser\Node\Stmt\ClassMethod $firstClassMethod */
        $firstClassMethod = $classStmt->stmts[0];

        return $firstClassMethod;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolvedClass
     * @param string $methodName
     *
     * @return bool
     */
    protected function methodExists(ResolvedClassInterface $resolvedClass, string $methodName): bool
    {
        $methodNode = $this->nodeFinder->findMethodNode($resolvedClass->getClassTokenTree(), $methodName);

        if (!$methodNode) {
            return false;
        }

        return true;
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
     * @throws \SprykerSdk\Spryk\Exception\ArgumentNotFoundException
     *
     * @return string
     */
    protected function getMethodName(SprykDefinitionInterface $sprykDefinition): string
    {
        $argumentCollection = $sprykDefinition->getArgumentCollection();

        foreach (static::ARGUMENT_METHOD_NAME_CANDIDATES as $methodNameCandidate) {
            if ($argumentCollection->hasArgument($methodNameCandidate)) {
                return $argumentCollection->getArgument($methodNameCandidate);
            }
        }

        throw new ArgumentNotFoundException(sprintf(
            'Could not find method argument value. You need to add on of "%s" as method argument to your spryk "%s".',
            implode(', ', static::ARGUMENT_METHOD_NAME_CANDIDATES),
            $sprykDefinition->getSprykName(),
        ));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetClassName(SprykDefinitionInterface $sprykDefinition): string
    {
        $className = $this->getTargetArgument($sprykDefinition);

        if (strpos($className, '\\') === false && $sprykDefinition->getArgumentCollection()->hasArgument(static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN)) {
            $className = $sprykDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN)->getValue();
        }

        $className = str_replace(DIRECTORY_SEPARATOR, '\\', $className);

        $this->assertFullyQualifiedClassName($className);

        return $className;
    }

    /**
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\NotAFullyQualifiedClassNameException
     *
     * @return void
     */
    protected function assertFullyQualifiedClassName(string $className): void
    {
        if (strpos($className, '\\') === false) {
            throw new NotAFullyQualifiedClassNameException(sprintf(
                'Expected a fully qualified class name for reflection but got "%s". ' .
                'Make sure you pass a fully qualified class name in the "%s" argument or use the "%s" argument with a value like "%s" in your spryk ' .
                'to be able to compute the fully qualified class name from the given arguments.',
                $className,
                static::ARGUMENT_TARGET,
                static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN,
                '{{ organization }}\\Zed\\{{ module }}\\Business\\{{ subDirectory | convertToClassNameFragment }}\\{{ className }}',
            ));
        }
    }
}
