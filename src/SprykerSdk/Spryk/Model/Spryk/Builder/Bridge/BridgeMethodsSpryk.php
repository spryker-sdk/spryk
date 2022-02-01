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
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddMethodVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class BridgeMethodsSpryk implements SprykBuilderInterface
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
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface $reflectionHelper
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface $methodHelper
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     * @param \PhpParser\Parser $parser
     * @param \PhpParser\Lexer $lexer
     */
    public function __construct(
        TemplateRendererInterface $renderer,
        ReflectionHelperInterface $reflectionHelper,
        MethodHelperInterface $methodHelper,
        FileResolverInterface $fileResolver,
        NodeFinderInterface $nodeFinder,
        Parser $parser,
        Lexer $lexer
    ) {
        $this->renderer = $renderer;
        $this->reflectionHelper = $reflectionHelper;
        $this->methodHelper = $methodHelper;
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
        return 'bridgeMethods';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
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
        $resolved = $this->fileResolver->resolve($this->getTargetClassName($sprykDefinition));

        $reflectionMethods = $this->getReflectionMethods($resolved, $sprykDefinition);

        foreach ($reflectionMethods as $reflectionMethod) {
            $returnTypeAnnotation = $this->getReturnTypeAnnotationFromDocBlock($reflectionMethod->getDocComment());

            $arguments = [
                'docBlock' => $this->cleanMethodDocBlock($reflectionMethod->getDocComment()),
                'methodName' => $reflectionMethod->getName(),
                'dependentModule' => $this->getStringArgumentValue(static::ARGUMENT_DEPENDENT_MODULE, $sprykDefinition),
                'dependencyType' => $this->getStringArgumentValue(static::ARGUMENT_DEPENDENCY_TYPE, $sprykDefinition),
                'return' => ($returnTypeAnnotation !== 'void'),
                'methodReturnType' => $this->methodHelper->getMethodReturnType($reflectionMethod),
                'parameter' => $this->methodHelper->getParameter($reflectionMethod),
                'parameterWithoutTypes' => $this->methodHelper->getParameterNames($reflectionMethod),
            ];

            $methodContent = $this->renderer->render(
                $this->getStringArgumentValue(static::ARGUMENT_TEMPLATE, $sprykDefinition),
                $arguments,
            );

            $traverser = new NodeTraverser();
            $traverser->addVisitor(new AddMethodVisitor($this->getClassMethodNode($methodContent)));
            $newStmts = $traverser->traverse($resolved->getClassTokenTree());

            $resolved->setClassTokenTree($newStmts);

            $style->report(sprintf(
                'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
                $reflectionMethod->getName(),
                $sprykDefinition->getArgumentCollection()->getArgument('target'),
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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function getReflectionMethods(ResolvedClassInterface $resolvedClass, SprykDefinitionInterface $sprykDefinition): array
    {
        $sourceReflectionClass = $this->reflectionHelper->getReflectionClassByClassName(
            $this->getSourceClassName($sprykDefinition),
        );

        $methodNames = $this->getMethodNames($sprykDefinition);

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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetClassName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->getStringArgumentValue(static::ARGUMENT_TARGET, $sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getSourceClassName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->getStringArgumentValue(static::ARGUMENT_SOURCE_CLASS, $sprykDefinition);
    }

    /**
     * @param string $argumentName
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getStringArgumentValue(string $argumentName, SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument($argumentName)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function getMethodNames(SprykDefinitionInterface $sprykDefinition): array
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_METHODS)
            ->getValue();
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
