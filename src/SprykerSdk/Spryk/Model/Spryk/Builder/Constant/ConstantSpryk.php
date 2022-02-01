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
use SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor\AddConstantVisitor;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class ConstantSpryk implements SprykBuilderInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_TARGET = 'target';

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
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface
     */
    protected FileResolverInterface $fileResolver;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface
     */
    protected NodeFinderInterface $nodeFinder;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\NodeFinder\NodeFinderInterface $nodeFinder
     */
    public function __construct(FileResolverInterface $fileResolver, NodeFinderInterface $nodeFinder)
    {
        $this->fileResolver = $fileResolver;
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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        $constantName = $this->getConstantName($sprykDefinition);

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedClassInterface|null $resolvedClass */
        $resolvedClass = $this->fileResolver->resolve($this->getTargetArgument($sprykDefinition));

        if (!$resolvedClass) {
            return false;
        }

        return (!$this->constantExists($resolvedClass, $constantName));
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
        $resolvedClass = $this->fileResolver->resolve($this->getTargetArgument($sprykDefinition));

        $traverser = new NodeTraverser();

        $traverser->addVisitor(new AddConstantVisitor(
            $this->getConstantName($sprykDefinition),
            $this->getConstantValue($sprykDefinition),
            $this->getConstantVisibility($sprykDefinition),
        ));

        $newStmts = $traverser->traverse($resolvedClass->getClassTokenTree());
        $resolvedClass->setClassTokenTree($newStmts);

        $style->report(sprintf(
            'Added constant "<fg=green>%s</>" to "<fg=green>%s</>"',
            $this->getConstantName($sprykDefinition),
            $sprykDefinition->getArgumentCollection()->getArgument('target'),
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
    protected function getConstantVisibility(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_VISIBILITY)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getConstantName(SprykDefinitionInterface $sprykDefinition): string
    {
        $constantName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_NAME)
            ->getValue();

        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToUnderscore())
            ->attach(new StringToUpper());

        return $filterChain->filter($constantName);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getConstantValue(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_VALUE)
            ->getValue();
    }
}
