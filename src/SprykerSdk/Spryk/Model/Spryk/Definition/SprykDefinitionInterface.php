<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

interface SprykDefinitionInterface
{
    /**
     * @return string
     */
    public function getBuilder(): string;

    /**
     * @param string $builder
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setBuilder(string $builder): self;

    /**
     * @return string
     */
    public function getSprykName(): string;

    /**
     * @param string $sprykName
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setSprykName(string $sprykName): self;

    /**
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config);

    /**
     * @return array
     */
    public function getConfig(): array;

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function getArgumentCollection(): ArgumentCollectionInterface;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setArgumentCollection(ArgumentCollectionInterface $argumentCollection): self;

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPreSpryks(): array;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[] $preSpryks
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setPreSpryks(array $preSpryks): self;

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPostSpryks(): array;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[] $postSpryks
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setPostSpryks(array $postSpryks): self;

    /**
     * @return string
     */
    public function getMode(): string;

    /**
     * @param string $mode
     *
     * @return $this
     */
    public function setMode(string $mode);
}
