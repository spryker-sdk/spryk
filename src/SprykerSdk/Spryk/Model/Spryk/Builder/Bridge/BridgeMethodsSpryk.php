<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge;

use PhpParser\Lexer;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddMethodVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\SprykConfig;

class BridgeMethodsSpryk extends AbstractBuilder
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
    public const ARGUMENT_SOURCE_CLASS = 'sourceClass';

    /**
     * @var string
     */
    public const ARGUMENT_METHODS = 'methods';

    /**
     * @var string
     */
    public const ARGUMENT_DEPENDENT_MODULE = 'dependentModule';

    /**
     * @var string
     */
    public const ARGUMENT_DEPENDENCY_TYPE = 'dependencyType';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected TemplateRendererInterface $renderer;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface
     */
    protected ReflectionHelperInterface $reflectionHelper;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface
     */
    protected MethodHelperInterface $methodHelper;

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
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface $reflectionHelper
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface $methodHelper
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     * @param \PhpParser\Parser $parser
     * @param \PhpParser\Lexer $lexer
     */
    public function __construct(
        SprykConfig $config,
        FileResolverInterface $fileResolver,
        TemplateRendererInterface $renderer,
        ReflectionHelperInterface $reflectionHelper,
        MethodHelperInterface $methodHelper,
        NodeFinderInterface $nodeFinder,
        Parser $parser,
        Lexer $lexer
    ) {
        parent::__construct($config, $fileResolver);

        $this->renderer = $renderer;
        $this->reflectionHelper = $reflectionHelper;
        $this->methodHelper = $methodHelper;
        $this->nodeFinder = $nodeFinder;
        $this->parser = $parser;
        $this->lexer = $lexer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'bridgeMethods';
    }

    /**
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTarget());

        $reflectionMethods = $this->getReflectionMethods($resolved);

        foreach ($reflectionMethods as $reflectionMethod) {
            $returnTypeAnnotation = $this->getReturnTypeAnnotationFromDocBlock($reflectionMethod->getDocComment());

            $arguments = [
                'docBlock' => $this->cleanMethodDocBlock($reflectionMethod->getDocComment()),
                'methodName' => $reflectionMethod->getName(),
                'dependentModule' => $this->getStringArgument(static::ARGUMENT_DEPENDENT_MODULE),
                'dependencyType' => $this->getStringArgument(static::ARGUMENT_DEPENDENCY_TYPE),
                'return' => ($returnTypeAnnotation !== 'void'),
                'methodReturnType' => $this->methodHelper->getMethodReturnType($reflectionMethod),
                'parameter' => $this->methodHelper->getParameter($reflectionMethod),
                'parameterWithoutTypes' => $this->methodHelper->getParameterNames($reflectionMethod),
            ];

            $methodContent = $this->renderer->render(
                $this->getStringArgument(static::ARGUMENT_TEMPLATE),
                $arguments,
            );

            $traverser = new NodeTraverser();
            $traverser->addVisitor(new AddMethodVisitor($this->getClassMethodNode($methodContent)));
            $newStmts = $traverser->traverse($resolved->getClassTokenTree());

            $resolved->setClassTokenTree($newStmts);

            $this->log(sprintf(
                'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
                $reflectionMethod->getName(),
                $this->getTarget(),
            ));
        }
    }

    /**
     * @param string $classMethod
     *
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function getClassMethodNode(string $classMethod): ClassMethod
    {
        $methodContent = sprintf('<?php class FooBar {%s}', $classMethod);

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
     *
     * @return array
     */
    protected function getReflectionMethods(ResolvedClassInterface $resolvedClass): array
    {
        $sourceReflectionClass = $this->reflectionHelper->getReflectionClassByClassName(
            $this->getSourceClassName(),
        );

        $methodNames = $this->getMethodNames();

        $targetImmediateMethods = $this->getMethodNamesFromResolvedClass($resolvedClass);

        $reflectionMethods = [];

        foreach ($methodNames as $methodName) {
            if (!isset($targetImmediateMethods[$methodName])) {
                $reflectionMethods[] = $sourceReflectionClass->getMethod($methodName);
            }
        }

        return $reflectionMethods;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolvedClass
     *
     * @return array<string, string>
     */
    protected function getMethodNamesFromResolvedClass(ResolvedClassInterface $resolvedClass): array
    {
        return $this->nodeFinder->findMethodNames($resolvedClass->getClassTokenTree());
    }

    /**
     * @phpstan-return class-string
     *
     * @return string
     */
    protected function getSourceClassName(): string
    {
        /** @phpstan-var class-string */
        return $this->getStringArgument(static::ARGUMENT_SOURCE_CLASS);
    }

    /**
     * @return array
     */
    protected function getMethodNames(): array
    {
        return $this->getArrayArgument(static::ARGUMENT_METHODS);
    }

    /**
     * @param string $docComment
     *
     * @return string
     */
    protected function cleanMethodDocBlock(string $docComment): string
    {
        $docCommentWithoutExtras = preg_replace('/.+?(?=@param|@return)/ms', '/**' . PHP_EOL . ' * ', $docComment, 1);

        if ($docCommentWithoutExtras !== null) {
            $docComment = $docCommentWithoutExtras;
        }

        return $this->addSpacingToDocComment($docComment);
    }

    /**
     * @param string $docComment
     *
     * @return string
     */
    protected function addSpacingToDocComment(string $docComment): string
    {
        $docCommentLines = explode(PHP_EOL, $docComment);
        array_walk($docCommentLines, function (&$docCommentLine): void {
            $docCommentLine = str_repeat(' ', 4) . $docCommentLine;
        });

        return implode(PHP_EOL, $docCommentLines);
    }

    /**
     * @param string $docComment
     *
     * @return string
     */
    protected function getReturnTypeAnnotationFromDocBlock(string $docComment): string
    {
        preg_match('/@return (.+)/', $docComment, $returnType);

        if (!$returnType) {
            return '';
        }

        return $returnType[1];
    }
}
