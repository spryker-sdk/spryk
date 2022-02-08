<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk;

use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SprykFacade implements SprykFacadeInterface
{
//    /**
//     * @var \SprykerSdk\Spryk\SprykFactory|null
//     */
//    protected $factory;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface
     */
    protected SprykExecutorInterface $executor;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface
     */
    protected SprykDefinitionDumperInterface $definitionDumper;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface
     */
    protected ArgumentListGeneratorInterface $argumentListGenerator;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface
     */
    protected ArgumentListReaderInterface $argumentListReader;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected SprykConfigurationLoaderInterface $configurationLoader;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface $executor
     * @param \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface $definitionDumper
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface $argumentListGenerator
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface $argumentListReader
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $configurationLoader
     */
    public function __construct(
        SprykExecutorInterface $executor,
        SprykDefinitionDumperInterface $definitionDumper,
        ArgumentListGeneratorInterface $argumentListGenerator,
        ArgumentListReaderInterface $argumentListReader,
        SprykConfigurationLoaderInterface $configurationLoader
    ) {
        $this->executor = $executor;
        $this->definitionDumper = $definitionDumper;
        $this->argumentListGenerator = $argumentListGenerator;
        $this->argumentListReader = $argumentListReader;
        $this->configurationLoader = $configurationLoader;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $sprykExecutorConfiguration
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function executeSpryk(
        SprykExecutorConfigurationInterface $sprykExecutorConfiguration,
        SprykStyleInterface $style
    ): void {
        $this->executor->execute($sprykExecutorConfiguration, $style);
    }

    /**
     * @param int|null $level
     *
     * @return array
     */
    public function getSprykDefinitions(?int $level = null): array
    {
        return $this->definitionDumper->dump($level);
    }

    /**
     * @param array $argumentsList
     *
     * @return int
     */
    public function generateArgumentList(array $argumentsList): int
    {
        return $this->argumentListGenerator->generateArgumentList($argumentsList);
    }

    /**
     * @return array
     */
    public function getArgumentList(): array
    {
        return $this->argumentListReader->getArgumentList();
    }

    /**
     * @param string $sprykName
     * @param string|null $sprykMode
     *
     * @return array
     */
    public function getSprykDefinition(string $sprykName, ?string $sprykMode = null): array
    {
        return $this->configurationLoader->loadSpryk($sprykName, $sprykMode);
    }
}
