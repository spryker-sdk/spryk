<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Console;

use Spryker\Spryk\SprykFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SprykDumpConsole extends Command
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
            ->setHeaders(['Spryk name'])
            ->setRows($sprykDefinitions);
        ;
        $table->render();
    }

    /**
     * @return \Spryker\Spryk\SprykFacade
     */
    protected function getFacade(): SprykFacade
    {
        return new SprykFacade();
    }

    /**
     * @param array $sprykDefinitions
     *
     * @return array
     */
    protected function formatForTable(array $sprykDefinitions): array
    {
        $formatted = [];
        foreach ($sprykDefinitions as $sprykDefinition) {
            $formatted[] = [$sprykDefinition];
        }

        return $formatted;
    }
}
