<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
     * @return $this
     */
    public function setBuilder(string $builder);

    /**
     * @return string
     */
    public function getSprykName(): string;

    /**
     * @param string $sprykName
     *
     * @return $this
     */
    public function setSprykName(string $sprykName);

    /**
     * @return string
     */
    public function getSprykDefinitionKey(): string;

    /**
     * @param string $sprykDefinitionKey
     *
     * @return $this
     */
    public function setSprykDefinitionKey(string $sprykDefinitionKey);

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
     * @return $this
     */
    public function setArgumentCollection(ArgumentCollectionInterface $argumentCollection);

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition>
     */
    public function getExcludedSpryks(): array;

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition> $excludedSpryks
     *
     * @return $this
     */
    public function setExcludedSpryks(array $excludedSpryks);

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition>
     */
    public function getPreSpryks(): array;

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition> $preSpryks
     *
     * @return $this
     */
    public function setPreSpryks(array $preSpryks);

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition>
     */
    public function getPostSpryks(): array;

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition> $postSpryks
     *
     * @return $this
     */
    public function setPostSpryks(array $postSpryks);

    /**
     * @return array<string>
     */
    public function getPreCommands(): array;

    /**
     * @param array<string> $preCommands
     *
     * @return $this
     */
    public function setPreCommands(array $preCommands);

    /**
     * @return array<string>
     */
    public function getPostCommands(): array;

    /**
     * @param array<string> $postCommands
     *
     * @return $this
     */
    public function setPostCommands(array $postCommands);

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
