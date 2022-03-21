<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Spryk\Model\Spryk\Builder\NodeVisitor;

use PhpParser\Node;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassConst;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use PhpParser\Node\Stmt\TraitUse;
use PhpParser\NodeVisitorAbstract;

class OrderStatementsInClassVisitor extends NodeVisitorAbstract
{
    /**
     * @param \PhpParser\Node $node
     *
     * @return \PhpParser\Node|int|null
     */
    public function enterNode(Node $node)
    {
        if (!($node instanceof Class_)) {
            return $node;
        }

        $traitStatements = [];
        $constStatements = [];
        $propertyStatements = [];
        $methodStatements = [];

        $unknown = [];

        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof TraitUse) {
                $traitStatements[] = $stmt;

                continue;
            }
            if ($stmt instanceof ClassConst) {
                $constStatements[] = $stmt;

                continue;
            }
            if ($stmt instanceof Property) {
                $propertyStatements[] = $stmt;

                continue;
            }
            if ($stmt instanceof ClassMethod) {
                $methodStatements[] = $stmt;

                continue;
            }

            $unknown[] = $stmt;
        }

        $orderedStatements = $this->orderStatements($traitStatements, $constStatements, $propertyStatements, $methodStatements);
        $orderedStatements += $unknown;

        $node->stmts = $orderedStatements;

        return $node;
    }

    /**
     * @param array $traitStatements
     * @param array $constStatements
     * @param array $propertyStatements
     * @param array $methodStatements
     *
     * @return array
     */
    protected function orderStatements(array $traitStatements, array $constStatements, array $propertyStatements, array $methodStatements): array
    {
        $orderedStatements = [];
        $orderedStatements = array_merge($orderedStatements, $this->orderTraitStatements($traitStatements));
        $orderedStatements = array_merge($orderedStatements, $this->orderByVisibility($constStatements));
        $orderedStatements = array_merge($orderedStatements, $this->orderByVisibility($propertyStatements));
        $orderedStatements = array_merge($orderedStatements, $this->orderMethodStatements($methodStatements));

        return $orderedStatements;
    }

    /**
     * @param array $traitStatements
     *
     * @return array
     */
    protected function orderTraitStatements(array $traitStatements): array
    {
        return $traitStatements;
    }

    /**
     * @param array<\PhpParser\Node\Stmt\ClassMethod> $methodStatements
     *
     * @return array
     */
    protected function orderMethodStatements(array $methodStatements): array
    {
        $orderedMethods = [];
        $unorderedMethods = [];

        $specialMethodNames = [
            'provideCommunicationLayerDependencies' => true,
            'provideBusinessLayerDependencies' => true,
            'providePersistenceLayerDependencies' => true,
            'provideDependencies' => true,
            'provideServiceDependencies' => true,
        ];

        foreach ($methodStatements as $methodStatement) {
            $name = (string)$methodStatement->name;

            if ($name === '__construct') {
                array_unshift($orderedMethods, $methodStatement);

                continue;
            }
            if (isset($specialMethodNames[$name])) {
                array_push($orderedMethods, $methodStatement);

                continue;
            }

            $unorderedMethods[] = $methodStatement;
        }

        $orderedUnorderedMethods = $this->orderByVisibility($unorderedMethods);

        return array_merge($orderedMethods, $orderedUnorderedMethods);
    }

    /**
     * @param array<(\PhpParser\Node\Stmt\ClassMethod|\PhpParser\Node\Stmt\Property|\PhpParser\Node\Stmt\ClassConst)> $unorderedStatements
     *
     * @return array
     */
    protected function orderByVisibility(array $unorderedStatements): array
    {
        $public = [];
        $protected = [];
        $private = [];

        foreach ($unorderedStatements as $unorderedStatement) {
            if ($unorderedStatement->isPublic()) {
                $public[] = $unorderedStatement;

                continue;
            }
            if ($unorderedStatement->isProtected()) {
                $protected[] = $unorderedStatement;

                continue;
            }
            $private[] = $unorderedStatement;
        }

        return [...$public, ...$protected, ...$private];
    }
}
