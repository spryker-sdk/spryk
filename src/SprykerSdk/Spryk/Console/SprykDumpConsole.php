<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Console;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SprykDumpConsole extends AbstractSprykConsole
{
    /**
     * @return void
     */
    protected function configure()
    {
        $this->setName('spryk:dump')
            ->setDescription('Dumps a list of all Spryk definitions.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $sprykDefinitions = $this->getFacade()->getSprykDefinitions();
        $sprykDefinitions = $this->formatForTable($sprykDefinitions);

        $output->writeln('List of all Spryk definitions:');

        $table = new Table($output);
        $table
            ->setHeaders(['Spryk name', 'Description'])
            ->setRows($sprykDefinitions);
        $table->render();
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function formatForTable(array $sprykDefinitions): array
    {
        $formatted = [];
        foreach ($sprykDefinitions as $sprykName => $sprykDefinition) {
            $formatted[$sprykName] = [$sprykName, $sprykDefinition['description']];
        }
        sort($formatted);

        return $formatted;
    }
}
