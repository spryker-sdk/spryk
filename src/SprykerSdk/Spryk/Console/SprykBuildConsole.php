<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Console;

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
            ->setDescription('Builds a cache for all possible Spryk arguments.');
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

        $output->writeln(sprintf('Found "%s" Spryk definitions.', count($sprykDefinitions)));

        $output->writeln('Generating argument list ...');
        $this->getFacade()->generateArgumentList($sprykDefinitions);
        $output->writeln('Argument list has been generated.');
    }
}
