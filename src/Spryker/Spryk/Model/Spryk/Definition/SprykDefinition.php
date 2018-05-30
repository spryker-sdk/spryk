<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

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
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $argumentCollection;

    /**
     * @var bool
     */
    protected $isCalled = false;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected $preSpryks = [];

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    protected $postSpryks = [];

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
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setBuilder(string $builder): SprykDefinitionInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setSprykName(string $sprykSprykName): SprykDefinitionInterface
    {
        $this->sprykName = $sprykSprykName;

        return $this;
    }

    /**
     * @param array $config
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setConfig(array $config): SprykDefinitionInterface
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
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function getArgumentCollection(): ArgumentCollectionInterface
    {
        return $this->argumentCollection;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setArgumentCollection(ArgumentCollectionInterface $argumentCollection): SprykDefinitionInterface
    {
        $this->argumentCollection = $argumentCollection;

        return $this;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPreSpryks(): array
    {
        return $this->preSpryks;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[] $preSpryks
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setPreSpryks(array $preSpryks): SprykDefinitionInterface
    {
        $this->preSpryks = $preSpryks;

        return $this;
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[]
     */
    public function getPostSpryks(): array
    {
        return $this->postSpryks;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinition[] $postSpryks
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface
     */
    public function setPostSpryks(array $postSpryks): SprykDefinitionInterface
    {
        $this->postSpryks = $postSpryks;

        return $this;
    }
}
