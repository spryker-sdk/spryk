<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SprykDumpConsole extends AbstractSprykConsole
{
    /**
     * @var string
     */
    protected const COMMAND_NAME = 'spryk:dump';

    /**
     * @var string
     */
    protected const COMMAND_DESCRIPTION = 'Dumps a list of all Spryk definitions.';

    /**
     * @var string
     */
    public const ARGUMENT_SPRYK = 'spryk';

    /**
     * @var string
     */
    protected const OPTION_LEVEL = 'level';

    /**
     * @var string
     */
    protected const OPTION_LEVEL_SHORT = 'l';

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addArgument(static::ARGUMENT_SPRYK, InputOption::VALUE_OPTIONAL, 'Name of a specific Spryk for which the options should be dumped.')
            ->addOption(
                static::OPTION_LEVEL,
                static::OPTION_LEVEL_SHORT,
                InputOption::VALUE_REQUIRED,
                'Spryk visibility level (1, 2, 3, all). By default = 1 (main spryk commands).',
                (string)SprykConfig::SPRYK_DEFAULT_DUMP_LEVEL,
            );
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $level = $this->getLevelOption($input);

        $sprykName = current((array)$input->getArgument(static::ARGUMENT_SPRYK));
        if ($sprykName !== false) {
            $this->dumpSprykOptions($output, $sprykName);

            return static::CODE_SUCCESS;
        }

        $this->dumpAllSpryks($output, $level);

        return static::CODE_SUCCESS;
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     *
     * @return int|null
     */
    protected function getLevelOption(InputInterface $input): ?int
    {
        $level = current((array)$input->getOption(static::OPTION_LEVEL));

        return $level === 'all' ? null : (int)$level;
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param int|null $level
     *
     * @return void
     */
    protected function dumpAllSpryks(OutputInterface $output, ?int $level): void
    {
        $sprykDefinitions = $this->getFacade()->getSprykDefinitions($level);
        $sprykDefinitions = $this->formatSpryks($sprykDefinitions);

        $output->writeln('List of Spryk definitions:');
        $this->printTable($output, ['Spryk name', 'Description'], $sprykDefinitions);
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $sprykName
     *
     * @return void
     */
    protected function dumpSprykOptions(OutputInterface $output, string $sprykName): void
    {
        $sprykDefinition = $this->getFacade()->getSprykDefinition($sprykName);
        $tableRows = $this->formatOptions($sprykDefinition[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);
        $this->printTitleBlock($output, sprintf('List of all "%s" options:', $sprykName));
        $this->printTable($output, ['Option'], $tableRows);

        $optionalSpryks = $this->getFormattedOptionalSpryks($sprykDefinition);
        if ($optionalSpryks !== []) {
            $this->printTitleBlock($output, 'Optional Spryks:');
            $this->printTable($output, ['Spryk'], $optionalSpryks);
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param string $title
     * @param string $style
     *
     * @return void
     */
    protected function printTitleBlock(OutputInterface $output, string $title, string $style = 'info'): void
    {
        $output->writeln(
            (new FormatterHelper())
                ->formatBlock($title, $style),
        );
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param array $headers
     * @param array $rows
     *
     * @return void
     */
    protected function printTable(OutputInterface $output, array $headers, array $rows): void
    {
        (new Table($output))
            ->setStyle('compact')
            ->setHeaders($headers)
            ->setRows($rows)
            ->render();
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function formatSpryks(array $sprykDefinitions): array
    {
        $formatted = [];
        foreach ($sprykDefinitions as $sprykName => $sprykDefinition) {
            $formatted[$sprykName] = [$sprykName, $sprykDefinition['description']];
        }
        sort($formatted);

        return $formatted;
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function formatOptions(array $sprykDefinitions): array
    {
        $formatted = ['mode' => ['mode']];
        foreach ($sprykDefinitions as $option => $optionDefinition) {
            if (isset($optionDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUE])) {
                continue;
            }

            $formatted[$option] = [$option];
        }
        sort($formatted);

        return $formatted;
    }

    /**
     * @param array $sprykDefinition
     *
     * @return array
     */
    protected function getFormattedOptionalSpryks(array $sprykDefinition): array
    {
        $optionalSpryks = [];
        $preAndPostSpryks = $this->getPreAndPostSpryks($sprykDefinition);
        $preAndPostSpryks = $this->filterSprykDefinitions($preAndPostSpryks);

        $flattenPreAndPostSpryks = array_reduce($preAndPostSpryks, 'array_merge', []);
        foreach ($flattenPreAndPostSpryks as $sprykName => $flattenPreAndPostSpryk) {
            if (!$this->isOptionalSpryk($flattenPreAndPostSpryk)) {
                continue;
            }

            $optionalSpryks[$sprykName] = [$sprykName];
        }

        return $optionalSpryks;
    }

    /**
     * @param array $sprykDefinition
     *
     * @return array
     */
    protected function getPreAndPostSpryks(array $sprykDefinition): array
    {
        return ($sprykDefinition['preSpryks'] ?? []) + ($sprykDefinition['postSpryks'] ?? []);
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function filterSprykDefinitions(array $sprykDefinitions): array
    {
        return array_filter($sprykDefinitions, 'is_array');
    }

    /**
     * @param array $sprykDefinition
     *
     * @return bool
     */
    protected function isOptionalSpryk(array $sprykDefinition): bool
    {
        return isset($sprykDefinition['isOptional']) && $sprykDefinition['isOptional'] === true;
    }
}
