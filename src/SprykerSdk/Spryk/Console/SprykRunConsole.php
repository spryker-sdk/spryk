<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;
use SprykerSdk\Spryk\Style\SprykStyle;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SprykRunConsole extends AbstractSprykConsole
{
    protected const COMMAND_NAME = 'spryk:run';
    protected const COMMAND_DESCRIPTION = 'Runs a Spryk build process.';
    public const ARGUMENT_SPRYK = 'spryk';
    public const ARGUMENT_TARGET_MODULE = 'targetModule';
    public const ARGUMENT_DEPENDENT_MODULE = 'dependentModule';

    public const OPTION_INCLUDE_OPTIONALS = 'include-optional';
    public const OPTION_INCLUDE_OPTIONALS_SHORT = 'i';

    /**
     * @var array|null
     */
    protected static $argumentsList;

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->setHelp($this->getHelpText())
            ->addArgument(static::ARGUMENT_SPRYK, InputArgument::REQUIRED, 'Name of the Spryk which should be build.')
            ->addArgument(static::ARGUMENT_TARGET_MODULE, InputArgument::OPTIONAL, 'Name of the target module in format "[Organization.]ModuleName[.LayerName]".')
            ->addArgument(static::ARGUMENT_DEPENDENT_MODULE, InputArgument::OPTIONAL, 'Name of the dependent module in format "[Organization.]ModuleName[.LayerName]".')
            ->addOption(static::OPTION_INCLUDE_OPTIONALS, static::OPTION_INCLUDE_OPTIONALS_SHORT, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Name(s) of the Spryks which are marked as optional but should be build.');

        foreach ($this->getSprykArguments() as $argumentDefinition) {
            $this->addOption(
                $argumentDefinition['name'],
                null,
                $argumentDefinition['mode'],
                $argumentDefinition['description']
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

        $sprykName = $this->getSprykName($input);
        $targetModuleName = $this->getTargetModuleName($input);
        $dependentModuleName = $this->getDependentModuleName($input);
        $this->getFacade()->executeSpryk(
            $sprykName,
            (array)OptionsContainer::getOption(static::OPTION_INCLUDE_OPTIONALS),
            $this->createSprykStyle($input, $output),
            $targetModuleName,
            $dependentModuleName
        );

        return static::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected function createSprykStyle(InputInterface $input, OutputInterface $output): SprykStyleInterface
    {
        return new SprykStyle(
            $input,
            $output
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getSprykName(InputInterface $input): string
    {
        return current((array)$input->getArgument(static::ARGUMENT_SPRYK));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getTargetModuleName(InputInterface $input): string
    {
        return current((array)$input->getArgument(static::ARGUMENT_TARGET_MODULE));
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return string
     */
    protected function getDependentModuleName(InputInterface $input): string
    {
        return current((array)$input->getArgument(static::ARGUMENT_DEPENDENT_MODULE));
    }

    /**
     * @return string
     */
    protected function getHelpText(): string
    {
        return 'Use `console spryk:dump <info>{SPRYK NAME}</info>` to get the options of a specific Spryk.';
    }
}
