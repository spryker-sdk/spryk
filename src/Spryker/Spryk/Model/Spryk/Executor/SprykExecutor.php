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
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function execute(string $sprykName, SprykStyleInterface $style): void
    {
        $this->definitionBuilder->setStyle($style);
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

        $style->startPreSpryks($sprykDefinition);
        $this->buildPreSpryks($sprykDefinition, $style);
        $style->endPreSpryks($sprykDefinition);

        $builder = $this->sprykBuilderCollection->getBuilder($sprykDefinition);

        $message = sprintf('<fg=green>%s</> already executed', $sprykDefinition->getSprykName());

        if ($builder->shouldBuild($sprykDefinition)) {
            $message = sprintf('<fg=green>%s</> build finished', $sprykDefinition->getSprykName());

            $builder->build($sprykDefinition);
        }

        $this->executedSpryks[$sprykDefinition->getSprykName()] = $sprykDefinition;

        $style->write($message);
        $style->newLine();

        $style->startPostSpryks($sprykDefinition);
        $this->buildPostSpryks($sprykDefinition, $style);
        $style->endPostSpryks($sprykDefinition);

        $style->endSpryk($sprykDefinition);
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
            $this->buildSpryk($postSprykDefinition, $style);
        }
    }
}
