<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Method;

use Exception;
use PhpParser\Lexer;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\NodeTraverser;
use PhpParser\Parser;
use SprykerSdk\Spryk\Exception\ArgumentNotFoundException;
use SprykerSdk\Spryk\Exception\NotAFullyQualifiedClassNameException;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddMethodVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\ReplaceMethodBodyNodeVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\SprykConfig;

class MethodSpryk extends AbstractBuilder
{
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
        return 'method';
    }

    /**
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        $methodName = $this->getMethodName();

        $resolvedClass = $this->getTargetClass();

        $methodExists = $this->methodExists($resolvedClass, $methodName);

        if (!$methodExists) {
            return true;
        }

        if ($this->arguments->hasArgument('allowOverride')) {
            return (bool)$this->arguments->getArgument('allowOverride')->getValue();
        }

        return false;
    }

    /**
     * @throws \Exception
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface
     */
    protected function getTargetClass(): ResolvedClassInterface
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolvedClass */
        $resolvedClass = $this->fileResolver->resolve($this->getTargetClassName());

        if (!$resolvedClass) {
            throw new Exception(sprintf('Could not find class "%s".', $this->getTargetClassName()));
        }

        return $resolvedClass;
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        $resolvedClass = $this->getTargetClass();

        $methodName = $this->getMethodName();
        $methodExists = $this->methodExists($resolvedClass, $methodName);

        $methodArgument = new Argument();
        $methodArgument
            ->setName('method')
            ->setValue($methodName);

        $this->arguments->addArgument($methodArgument);

        $classMethodNode = $this->getClassMethodNode();

        $bodyArgument = $this->arguments->hasArgument('body') ? $this->arguments->getArgument('body') : false;

        if ($bodyArgument && $bodyArgument->getAllowOverride() && $methodExists) {
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

        $this->log(sprintf(
            'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
            $this->getMethodName(),
            $this->getTarget(),
        ));
    }

    /**
     * @return \PhpParser\Node\Stmt\ClassMethod
     */
    protected function getClassMethodNode(): ClassMethod
    {
        $this->renderBody();
        $templateName = $this->getTemplateName();

        $methodContent = sprintf('<?php class Foo {%s}', $this->renderer->render(
            $templateName,
            $this->arguments->getArguments(),
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
     * In case the body:value refers to a template, render the template and add the code as body:value to the arguments
     * list. The method body rendered by this method will be used when the method for the class is created in
     * {@link \SprykerSdk\Spryk\Model\Spryk\Builder\Method\MethodSpryk::getClassMethodNode()}
     *
     * @example
     * ```
     * arguments:
     *     body:
     *         value: path/to/template.php.twig
     * ```
     *
     * @return void
     */
    protected function renderBody(): void
    {
        $body = $this->getBody();

        if (preg_match('/\.php\.twig/', $body)) {
            $body = $this->renderer->render(
                $body,
                $this->arguments->getArguments(),
            );
            $this->arguments->getArgument('body')->setValue($body);
        }
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
     * @return string
     */
    protected function getTemplateName(): string
    {
        return $this->getStringArgument(static::ARGUMENT_TEMPLATE);
    }

    /**
     * @return string
     */
    protected function getBody(): string
    {
        return $this->arguments->hasArgument('body') ? $this->arguments->getArgument('body') : '';
    }

    /**
     * @throws \SprykerSdk\Spryk\Exception\ArgumentNotFoundException
     *
     * @return string
     */
    protected function getMethodName(): string
    {
        foreach (static::ARGUMENT_METHOD_NAME_CANDIDATES as $methodNameCandidate) {
            if ($this->arguments->hasArgument($methodNameCandidate)) {
                return $this->arguments->getArgument($methodNameCandidate);
            }
        }

        throw new ArgumentNotFoundException(sprintf(
            'Could not find method argument value. You need to add on of "%s" as method argument to your spryk "%s".',
            implode(', ', static::ARGUMENT_METHOD_NAME_CANDIDATES),
            $this->getSprykName(),
        ));
    }

    /**
     * @return string
     */
    protected function getTargetClassName(): string
    {
        $className = $this->getTarget();

        if (strpos($className, '\\') === false && $this->arguments->hasArgument(static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN)) {
            $className = $this->getStringArgument(static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN);
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
