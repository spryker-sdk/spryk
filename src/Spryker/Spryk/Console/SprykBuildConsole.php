<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Console;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SprykBuildConsole extends AbstractSprykConsole
{
    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('spryk:build')
            ->setDescription('Build a list of all Spryk definitions.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $output->writeln('Getting all Spryk definitions...');
        $sprykDefinitions = $this->getFacade()->getSprykDefinitions();
        $output->writeln(count($sprykDefinitions) . ' has been founded.');

        $output->writeln('Building argument list ...');
        $sprykArgumentList = $this->getFacade()->buildArgumentList($sprykDefinitions);

        $this->getFacade()->generateArgumentList($sprykArgumentList);
        $output->writeln('Argument list has been generated.');
    }
}
