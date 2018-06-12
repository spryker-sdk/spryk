<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Console;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver\OptionsContainer;
use Spryker\Spryk\Style\SprykStyle;
use Spryker\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SprykRunConsole extends AbstractSprykConsole
{
    const ARGUMENT_SPRYK = 'spryk';
    const ARGUMENT_SPRYK_SHORT = 's';

    const OPTION_INCLUDE_OPTIONALS = 'include-optional';
    const OPTION_INCLUDE_OPTIONALS_SHORT = 'i';

    /**
     * @var array|null
     */
    protected static $argumentsList;

    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * @var \Spryker\Spryk\Style\SprykStyleInterface
     */
    protected $output;

    /**
     * @return void
     */
    protected function configure()
    {
        $sprykArguments = $this->getSprykArguments();
        $this->setName('spryk:run')
            ->setDescription('Runs a Spryk build process.')
            ->addArgument(static::ARGUMENT_SPRYK, InputArgument::REQUIRED, 'Name of the Spryk which should be build.')
            ->addOption(static::OPTION_INCLUDE_OPTIONALS, static::OPTION_INCLUDE_OPTIONALS_SHORT, InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY, 'Name(s) of the Spryks which are marked as optional but should be build.');

        foreach ($sprykArguments as $argumentName => $argumentDefinition) {
            $inputOption = InputOption::VALUE_REQUIRED;
            if (isset($argumentDefinition['multiline']) || isset($argumentDefinition['isMultiple'])) {
                $inputOption = InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY;
            }
            $this->addOption($argumentName, null, $inputOption, $argumentDefinition['description']);
        }
    }

    /**
     * @return array
     */
    protected function getSprykArguments(): array
    {
        if (static::$argumentsList === null) {
            static::$argumentsList = $this->buildArgumentList();
        }

        return static::$argumentsList;
    }

    /**
     * @return array
     */
    protected function buildArgumentList(): array
    {
        $standardArguments = [];
        $sprykArguments = [];
        foreach ($this->getSprykDefinitions() as $sprykName => $sprykDefinition) {
            $standardArguments += $this->buildStandardArgumentList($sprykDefinition['arguments']);
            $sprykArguments += $this->buildSprykArgumentList($sprykName, $sprykDefinition['arguments']);
        }

        return $standardArguments + $sprykArguments;
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function buildStandardArgumentList(array $arguments): array
    {
        $standardArguments = [];
        foreach ($arguments as $argumentName => $argumentDefinition) {
            $argumentInfo = [
                'name' => $argumentName,
                'description' => sprintf('%s argument', $argumentName),
            ];

            if (isset($argumentDefinition['multiline'])) {
                $argumentInfo['multiline'] = true;
            }

            if (isset($argumentDefinition['isMultiple'])) {
                $argumentInfo['isMultiple'] = true;
            }

            $standardArguments[$argumentName] = $argumentInfo;
        }

        return $standardArguments;
    }

    /**
     * @param string $sprykName
     * @param array $arguments
     *
     * @return array
     */
    protected function buildSprykArgumentList(string $sprykName, array $arguments): array
    {
        $sprykArguments = [];
        foreach ($arguments as $argumentName => $argumentDefinition) {
            $sprykArguments[$sprykName . '.' . $argumentName] = [
                'name' => $argumentName,
                'description' => sprintf('%s %s argument', $sprykName, $argumentName),
            ];
        }

        return $sprykArguments;
    }

    /**
     * @return array
     */
    protected function getSprykDefinitions(): array
    {
        $sprykDefinitions = $this->getFacade()->getSprykDefinitions();

        return $this->filterValueArguments($sprykDefinitions);
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function filterValueArguments(array $sprykDefinitions): array
    {
        return array_filter($sprykDefinitions, function ($argumentDefinition) {
            return (!isset($argumentDefinition['value']));
        });
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = $this->createOutput($input, $output);

        OptionsContainer::setOptions($input->getOptions());

        $sprykName = $this->getSprykName($input);
        $this->getFacade()->executeSpryk(
            $sprykName,
            OptionsContainer::getOption(static::OPTION_INCLUDE_OPTIONALS),
            $this->output
        );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return \Spryker\Spryk\Style\SprykStyleInterface
     */
    protected function createOutput(InputInterface $input, OutputInterface $output): SprykStyleInterface
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
        return $input->getArgument(static::ARGUMENT_SPRYK);
    }
}
