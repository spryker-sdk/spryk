<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

interface SprykDefinitionInterface
{
    /**
     * @return string
     */
    public function getBuilder(): string;

    /**
     * @param string $builder
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setBuilder(string $builder): SprykDefinitionInterface;

    /**
     * @return string
     */
    public function getSprykName(): string;

    /**
     * @param string $sprykName
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setSprykName(string $sprykName): SprykDefinitionInterface;

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function getArgumentCollection(): ArgumentCollectionInterface;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setArgumentCollection(ArgumentCollectionInterface $argumentCollection): SprykDefinitionInterface;

    /**
     * @return bool
     */
    public function isCalled(): bool;

    /**
     * @param bool $isCalled
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setIsCalled(bool $isCalled): SprykDefinitionInterface;

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPreSpryks(): array;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[] $preSpryks
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setPreSpryks(array $preSpryks): SprykDefinitionInterface;

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPostSpryks(): array;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[] $postSpryks
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setPostSpryks(array $postSpryks): SprykDefinitionInterface;
}
