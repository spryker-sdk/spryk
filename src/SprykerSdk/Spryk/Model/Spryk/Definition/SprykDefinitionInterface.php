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
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPreSpryks(): array;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[] $preSpryks
     *
     * @return $this
     */
    public function setPreSpryks(array $preSpryks);

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPostSpryks(): array;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[] $postSpryks
     *
     * @return $this
     */
    public function setPostSpryks(array $postSpryks);

    /**
     * @return string[]
     */
    public function getPreCommands(): array;

    /**
     * @param string[] $preCommands
     *
     * @return $this
     */
    public function setPreCommands(array $preCommands);

    /**
     * @return string[]
     */
    public function getPostCommands(): array;

    /**
     * @param string[] $postCommands
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
