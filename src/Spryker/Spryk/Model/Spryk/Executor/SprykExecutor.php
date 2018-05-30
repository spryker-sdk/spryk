<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Executor;

use Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;

class SprykExecutor implements SprykExecutorInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface
     */
    protected $definitionBuilder;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface
     */
    protected $sprykBuilderCollection;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface[]
     */
    protected $executedSpryks = [];

    /**
     * @var string[]|null
     */
    protected $includeOptionalSubSpryks;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Builder\SprykDefinitionBuilderInterface $definitionBuilder
     * @param \Spryker\Spryk\Model\Spryk\Builder\Collection\SprykBuilderCollectionInterface $sprykBuilderCollection
     */
    public function __construct(SprykDefinitionBuilderInterface $definitionBuilder, SprykBuilderCollectionInterface $sprykBuilderCollection)
    {
        $this->definitionBuilder = $definitionBuilder;
        $this->sprykBuilderCollection = $sprykBuilderCollection;
    }

    /**
     * @param string $sprykName
     * @param array|null $includeOptionalSubSpryks
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function execute(string $sprykName, ?array $includeOptionalSubSpryks, SprykStyleInterface $style): void
    {
        $this->definitionBuilder->setStyle($style);
        $this->includeOptionalSubSpryks = $includeOptionalSubSpryks;

        $sprykDefinition = $this->definitionBuilder->buildDefinition($sprykName);

        $this->buildSpryk($sprykDefinition, $style);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildSpryk(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $style->startSpryk($sprykDefinition);

        $this->executePreSpryks($sprykDefinition, $style);
        $this->executeSpryk($sprykDefinition, $style);
        $this->executePostSpryks($sprykDefinition, $style);

        $style->endSpryk($sprykDefinition);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style)
    {
        $style->startPreSpryks($sprykDefinition);
        $this->buildPreSpryks($sprykDefinition, $style);
        $style->endPreSpryks($sprykDefinition);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executeSpryk(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style)
    {
        $builder = $this->sprykBuilderCollection->getBuilder($sprykDefinition);

        if ($builder->shouldBuild($sprykDefinition)) {
            $builder->build($sprykDefinition, $style);
        }

        $this->executedSpryks[$sprykDefinition->getSprykName()] = $sprykDefinition;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function executePostSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style)
    {
        $style->startPostSpryks($sprykDefinition);
        $this->buildPostSpryks($sprykDefinition, $style);
        $style->endPostSpryks($sprykDefinition);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildPreSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $preSpryks = $sprykDefinition->getPreSpryks();
        if (count($preSpryks) === 0) {
            return;
        }

        foreach ($preSpryks as $preSprykDefinition) {
            if (isset($this->executedSpryks[$preSprykDefinition->getSprykName()])) {
                continue;
            }
            $this->buildSpryk($preSprykDefinition, $style);
        }
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function buildPostSpryks(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $postSpryks = $sprykDefinition->getPostSpryks();
        if (count($postSpryks) === 0) {
            return;
        }

        foreach ($postSpryks as $postSprykDefinition) {
            if (isset($this->executedSpryks[$postSprykDefinition->getSprykName()])) {
                continue;
            }

            if (isset($postSprykDefinition->getConfig()['isOptional']) && !in_array($postSprykDefinition->getSprykName(), $this->includeOptionalSubSpryks)) {
                continue;
            }

            $this->buildSpryk($postSprykDefinition, $style);
        }
    }
}
