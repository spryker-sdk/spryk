<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Console;

use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SprykDumpConsole extends AbstractSprykConsole
{
    protected const COMMAND_NAME = 'spryk:dump';
    protected const COMMAND_DESCRIPTION = 'Dumps a list of all Spryk definitions.';

    public const ARGUMENT_SPRYK = 'spryk';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName(static::COMMAND_NAME)
            ->setDescription(static::COMMAND_DESCRIPTION)
            ->addArgument(static::ARGUMENT_SPRYK, InputOption::VALUE_OPTIONAL, 'Name of a specfic Spryk which its options should be dumped.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $spryk = current((array)$input->getArgument(static::ARGUMENT_SPRYK));
        if ($spryk !== false) {
            $sprykDefinition = $this->getFacade()->getSprykDefinition($spryk);
            $tableRows = $this->formatOptionsTable($sprykDefinition['arguments']);
            $output->writeln(
                (new FormatterHelper())
                    ->formatBlock(sprintf('List of all "%s" options:', $spryk), 'info')
            );

            $this->printTable($output, $tableRows, ['Option']);

            $optionalSpryks = $this->getOptionalSpryks($sprykDefinition);
            if ($optionalSpryks === []) {
                $output->writeln(
                    (new FormatterHelper())
                        ->formatBlock('Optional Spryks:', 'info')
                );

                $this->printTable($output, $optionalSpryks, ['Spryk']);
            }

            return;
        }

        $sprykDefinition = $this->getFacade()->getSprykDefinitions();
        $sprykDefinition = $this->formatSpryksTable($sprykDefinition);

        $output->writeln('List of all Spryk definitions:');
        $this->printTable($output, $sprykDefinition, ['Spryk name', 'Description']);
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param array $tableContent
     * @param array $header
     *
     * @return void
     */
    protected function printTable(OutputInterface $output, array $tableContent, array $header): void
    {
        (new Table($output))
            ->setHeaders($header)
            ->setRows($tableContent)
            ->render();
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function formatSpryksTable(array $sprykDefinitions): array
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
    protected function formatOptionsTable(array $sprykDefinitions): array
    {
        $formatted = ['mode' => ['mode']];
        foreach ($sprykDefinitions as $option => $optionDefinition) {
            if (isset($optionDefinition['value'])) {
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
    protected function getOptionalSpryks(array $sprykDefinition): array
    {
        $optionalSpryks = [];
        /** @var array $postAndPreSpryks */
        $postAndPreSpryks = ($sprykDefinition['preSpryks'] ?? []) + ($sprykDefinition['postSpryks'] ?? []);
        foreach ($postAndPreSpryks as $sprykDefinition) {
            if (!is_array($sprykDefinition)) {
                continue;
            }

            foreach ($sprykDefinition as $sprykName => $subSprykDefinition) {
                if (!isset($subSprykDefinition['isOptional']) || $subSprykDefinition['isOptional'] !== true) {
                    continue;
                }

                $optionalSpryks[$sprykName] = [$sprykName];
            }
        }

        return $optionalSpryks;
    }
}
