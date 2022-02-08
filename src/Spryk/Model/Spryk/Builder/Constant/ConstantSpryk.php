<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Constant;

use Laminas\Filter\FilterChain;
use Laminas\Filter\StringToUpper;
use Laminas\Filter\Word\CamelCaseToUnderscore;
use PhpParser\NodeTraverser;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddConstantVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\SprykConfig;

class ConstantSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    public const ARGUMENT_CONSTANT_NAME = 'name';

    /**
     * @var string
     */
    public const ARGUMENT_CONSTANT_VALUE = 'value';

    /**
     * @var string
     */
    public const ARGUMENT_CONSTANT_VISIBILITY = 'visibility';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface
     */
    protected NodeFinderInterface $nodeFinder;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     */
    public function __construct(SprykConfig $config, FileResolverInterface $fileResolver, NodeFinderInterface $nodeFinder)
    {
        parent::__construct($config, $fileResolver);
        $this->nodeFinder = $nodeFinder;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'constant';
    }

    /**
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        $constantName = $this->getConstantName();

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolvedClass */
        $resolvedClass = $this->fileResolver->resolve($this->getTarget());

        return ($resolvedClass instanceof ResolvedClassInterface && !$this->constantExists($resolvedClass, $constantName));
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolvedClass */
        $resolvedClass = $this->fileResolver->resolve($this->getTarget());

        $traverser = new NodeTraverser();

        $traverser->addVisitor(new AddConstantVisitor(
            $this->getConstantName(),
            $this->getConstantValue(),
            $this->getConstantVisibility(),
        ));

        $newStmts = $traverser->traverse($resolvedClass->getClassTokenTree());
        $resolvedClass->setClassTokenTree($newStmts);

        $this->log(sprintf(
            'Added constant "<fg=green>%s</>" to "<fg=green>%s</>"',
            $this->getConstantName(),
            $this->getTarget(),
        ));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface $resolvedClass
     * @param string $constantName
     *
     * @return bool
     */
    protected function constantExists(ResolvedClassInterface $resolvedClass, string $constantName): bool
    {
        $constNode = $this->nodeFinder->findConstantNode($resolvedClass->getClassTokenTree(), $constantName);

        if ($constNode === null) {
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    protected function getConstantVisibility(): string
    {
        return $this->getStringArgument(static::ARGUMENT_CONSTANT_VISIBILITY);
    }

    /**
     * @return string
     */
    protected function getConstantName(): string
    {
        $constantName = $this->getStringArgument(static::ARGUMENT_CONSTANT_NAME);

        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToUnderscore())
            ->attach(new StringToUpper());

        return $filterChain->filter($constantName);
    }

    /**
     * @return string
     */
    protected function getConstantValue(): string
    {
        return $this->getStringArgument(static::ARGUMENT_CONSTANT_VALUE);
    }
}
