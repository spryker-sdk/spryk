<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class SprykDefinition implements SprykDefinitionInterface
{
    /**
     * @var string
     */
    protected $builder;

    /**
     * @var string
     */
    protected $sprykName;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $argumentCollection;

    /**
     * @var bool
     */
    protected $isCalled = false;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected $preSpryks = [];

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected $postSpryks = [];

    /**
     * @var array
     */
    protected $mode;

    /**
     * @return string
     */
    public function getBuilder(): string
    {
        return $this->builder;
    }

    /**
     * @param string $builder
     *
     * @return $this
     */
    public function setBuilder(string $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * @return string
     */
    public function getSprykName(): string
    {
        return $this->sprykName;
    }

    /**
     * @param string $sprykSprykName
     *
     * @return $this
     */
    public function setSprykName(string $sprykSprykName)
    {
        $this->sprykName = $sprykSprykName;

        return $this;
    }

    /**
     * @param array $config
     *
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function getArgumentCollection(): ArgumentCollectionInterface
    {
        return $this->argumentCollection;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return $this
     */
    public function setArgumentCollection(ArgumentCollectionInterface $argumentCollection)
    {
        $this->argumentCollection = $argumentCollection;

        return $this;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPreSpryks(): array
    {
        return $this->preSpryks;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[] $preSpryks
     *
     * @return $this
     */
    public function setPreSpryks(array $preSpryks)
    {
        $this->preSpryks = $preSpryks;

        return $this;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPostSpryks(): array
    {
        return $this->postSpryks;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinition[] $postSpryks
     *
     * @return $this
     */
    public function setPostSpryks(array $postSpryks)
    {
        $this->postSpryks = $postSpryks;

        return $this;
    }

    /**
     * @return array
     */
    public function getMode(): array
    {
        return $this->mode;
    }

    /**
     * @param array $mode
     *
     * @return $this
     */
    public function setMode(array $mode)
    {
        $this->mode = $mode;

        return $this;
    }
}
