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
        $sprykName = current((array)$input->getArgument(static::ARGUMENT_SPRYK));
        if ($sprykName !== false) {
            $this->dumpSprykOptions($output, $sprykName);

            return;
        }

        $this->dumpAllSpryks($output);
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function dumpAllSpryks(OutputInterface $output): void
    {
        $sprykDefinitions = $this->getFacade()->getSprykDefinitions();
        $sprykDefinitions = $this->formatSpryksTable($sprykDefinitions);

        $output->writeln('List of all Spryk definitions:');
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
        $tableRows = $this->formatOptionsTable($sprykDefinition['arguments']);
        $output->writeln(
            (new FormatterHelper())
                ->formatBlock(sprintf('List of all "%s" options:', $sprykName), 'info')
        );

        $this->printTable($output, ['Option'], $tableRows);

        $optionalSpryks = $this->getOptionalSpryks($sprykDefinition);
        if ($optionalSpryks !== []) {
            $output->writeln(
                (new FormatterHelper())
                    ->formatBlock('Optional Spryks:', 'info')
            );

            $this->printTable($output, ['Spryk'], $optionalSpryks);
        }
    }

    /**
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     * @param array $header
     * @param array $tableContent
     *
     * @return void
     */
    protected function printTable(OutputInterface $output, array $header, array $tableContent): void
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
        $postAndPreSpryks = $this->getPostAndPreSpryks($sprykDefinition);
        $postAndPreSpryks = $this->filterEmptySprykDefinitions($postAndPreSpryks);
        foreach ($postAndPreSpryks as $sprykDefinitions) {
            foreach ($sprykDefinitions as $sprykName => $sprykDefinition) {
                if (!$this->isOptionalSpryk($sprykDefinition)) {
                    continue;
                }

                $optionalSpryks[$sprykName] = [$sprykName];
            }
        }

        return $optionalSpryks;
    }

    /**
     * @param array $sprykDefinition
     *
     * @return array
     */
    protected function getPostAndPreSpryks(array $sprykDefinition): array
    {
        return ($sprykDefinition['preSpryks'] ?? []) + ($sprykDefinition['postSpryks'] ?? []);
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function filterEmptySprykDefinitions(array $sprykDefinitions): array
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
