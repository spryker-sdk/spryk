<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use RuntimeException;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;
use SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\SprykFacadeInterface;
use SprykerSdk\Spryk\Style\SprykStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SprykRunConsole extends AbstractSprykConsole
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'spryk:run';

    /**
     * @var string
     */
    protected const COMMAND_DESCRIPTION = 'Runs a Spryk build process.';

    /**
     * @var string
     */
    public const ARGUMENT_SPRYK = 'spryk';

    /**
     * @var string
     */
    public const ARGUMENT_TARGET_MODULE = 'targetModule';

    /**
     * @var string
     */
    public const ARGUMENT_DEPENDENT_MODULE = 'dependentModule';

    /**
     * @var string
     */
    public const OPTION_INCLUDE_OPTIONALS = 'include-optional';

    /**
     * @var string
     */
    public const OPTION_INCLUDE_OPTIONALS_SHORT = 'i';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface
     */
    protected SprykExecutorConfigurationInterface $executorConfiguration;

    /**
     * @var array|null
     */
    protected static ?array $argumentsList = null;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\Configuration\SprykExecutorConfigurationInterface $executorConfiguration
     * @param \SprykerSdk\Spryk\SprykFacadeInterface $facade
     * @param string|null $name
     */
    public function __construct(SprykExecutorConfigurationInterface $executorConfiguration, SprykFacadeInterface $facade, ?string $name = null)
    {
        parent::__construct($facade, $name);

        $this->executorConfiguration = $executorConfiguration;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->setHelp($this->getHelpText())
            ->addArgument(static::ARGUMENT_SPRYK, InputArgument::REQUIRED, 'Name of the Spryk which should be build.')
            ->addArgument(static::ARGUMENT_TARGET_MODULE, InputArgument::OPTIONAL, 'Name of the target module in format "[Organization.]ModuleName[.LayerName]".')
            ->addArgument(static::ARGUMENT_DEPENDENT_MODULE, InputArgument::OPTIONAL, 'Name of the dependent module in format "[Organization.]ModuleName[.LayerName]".')
            ->addOption(static::OPTION_INCLUDE_OPTIONALS, static::OPTION_INCLUDE_OPTIONALS_SHORT, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Name(s) of the Spryks which are marked as optional but should be build.')
            ->addOption('dry-run', 'd', InputOption::VALUE_NONE, 'Only print a diff, do not change files');

        foreach ($this->getSprykArguments() as $argumentDefinition) {
            $this->addOption(
                $argumentDefinition['name'],
                null,
                $argumentDefinition[SprykConfig::NAME_ARGUMENT_MODE],
                $argumentDefinition['description'],
            );
        }
    }

    /**
     * @return array
     */
    protected function getSprykArguments(): array
    {
        if (static::$argumentsList === null) {
            static::$argumentsList = $this->getFacade()->getArgumentList();
        }

        return array_filter(static::$argumentsList, function (array $argumentDefinition) {
            return strpos($argumentDefinition['name'], '.') === false;
        });
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        OptionsContainer::setOptions($input->getOptions());

        $sprykExecutorConfiguration = $this->executorConfiguration->prepare(
            $this->getSprykName($input),
            (array)OptionsContainer::getOption(static::OPTION_INCLUDE_OPTIONALS),
            $this->getTargetModuleName($input),
            $this->getDependentModuleName($input),
        );

        $this->getFacade()->executeSpryk(
            $sprykExecutorConfiguration,
            new SprykStyle($input, $output),
        );

        return static::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected function getSprykName(InputInterface $input): string
    {
        $name = current((array)$input->getArgument(static::ARGUMENT_SPRYK));
        if ($name === false) {
            throw new RuntimeException('Cannot retrieve Spryk name');
        }

        return $name;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getTargetModuleName(InputInterface $input): string
    {
        return current((array)$input->getArgument(static::ARGUMENT_TARGET_MODULE)) ?: '';
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getDependentModuleName(InputInterface $input): string
    {
        return current((array)$input->getArgument(static::ARGUMENT_DEPENDENT_MODULE)) ?: '';
    }

    /**
     * @return string
     */
    protected function getHelpText(): string
    {
        return 'Use `console spryk:dump <info>{SPRYK NAME}</info>` to get the options of a specific Spryk.';
    }
}
