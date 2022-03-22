<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Parser;

use PhpParser\Lexer;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\CloningVisitor;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\Parser;
use ReflectionClass;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClass;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;

class ClassParser implements ParserInterface
{
    /**
     * @var \PhpParser\Parser
     */
    protected Parser $parser;

    /**
     * @var \PhpParser\Lexer
     */
    protected Lexer $lexer;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface
     */
    protected NodeFinderInterface $nodeFinder;

    /**
     * @param \PhpParser\Parser $parser
     * @param \PhpParser\Lexer $lexer
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     */
    public function __construct(Parser $parser, Lexer $lexer, NodeFinderInterface $nodeFinder)
    {
        $this->parser = $parser;
        $this->lexer = $lexer;
        $this->nodeFinder = $nodeFinder;
    }

    /**
     * @param string $type
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface
     */
    public function parse(string $type): ResolvedInterface
    {
        if (strpos($type, '<?php') !== false) {
            return $this->fromFileContent($type);
        }

        if (strpos($type, '.php') !== false) {
            return $this->fromFile($type);
        }

        return $this->fromClassName($type);
    }

    /**
     * @param string $className
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClass
     */
    protected function fromClassName(string $className): ResolvedClass
    {
        /** @phpstan-var class-string $className */
        $className = ltrim($className, '\\');

        $resolved = new ResolvedClass();
        $resolved->setClassName($className);
        $resolved->setFullyQualifiedClassName('\\' . $className);

        $reflectionClass = new ReflectionClass($className);
        $resolved->setReflectionClass($reflectionClass);

        $fileName = $reflectionClass->getFileName();

        if (!$fileName) {
            return $resolved;
        }

        $fileContents = (string)file_get_contents($fileName);

        $resolved = $this->fromFileContent($fileContents);
        $resolved->setFilePath($fileName);

        return $resolved;
    }

    /**
     * @param string $filePath
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClass
     */
    protected function fromFile(string $filePath): ResolvedClass
    {
        $fileContents = (string)file_get_contents($filePath);

        $resolved = $this->fromFileContent($fileContents);
        $resolved->setFilePath($filePath);
        $resolved->setOriginalContent($fileContents);

        return $resolved;
    }

    /**
     * @param string $fileContents
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClass
     */
    protected function fromFileContent(string $fileContents): ResolvedClass
    {
        /** @var array<\PhpParser\Node\Stmt> $ast */
        $ast = $this->parser->parse($fileContents);

        /** @var string $classOrInterfaceName */
        $classOrInterfaceName = $this->nodeFinder->findClassOrInterfaceName($ast);

        $resolved = new ResolvedClass();
        $resolved->setClassName($classOrInterfaceName);
        $resolved->setFullyQualifiedClassName('\\' . $classOrInterfaceName);

        $resolved->setOriginalContent($fileContents);

        $ast = $this->traverseOriginalSyntaxTree($ast);

        $resolved->setOriginalClassTokenTree($ast);
        $resolved->setClassTokenTree($ast);
        $resolved->setTokens($this->lexer->getTokens());

        return $resolved;
    }

    /**
     * @param array<\PhpParser\Node\Stmt> $originalSyntaxTree
     *
     * @return array<\PhpParser\Node>
     */
    protected function traverseOriginalSyntaxTree(array $originalSyntaxTree): array
    {
        $nodeTraverser = new NodeTraverser();
        $nodeTraverser->addVisitor(new CloningVisitor());
        $nodeTraverser->addVisitor(new NameResolver());

        return $nodeTraverser->traverse($originalSyntaxTree);
    }
}
