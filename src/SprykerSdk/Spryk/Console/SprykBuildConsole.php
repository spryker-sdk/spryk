<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
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
            ->setDescription('Builds a cache for all possible Spryk arguments. This command must only be used if a new argument was supplied.');
    }

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Getting all Spryk definitions...');
        $sprykDefinitions = $this->getFacade()->getSprykDefinitions();

        $output->writeln(sprintf('Found "%s" Spryk definitions.', count($sprykDefinitions)));

        $output->writeln('Generating argument list ...');
        $this->getFacade()->generateArgumentList($sprykDefinitions);
        $output->writeln('Argument list has been generated.');

        return static::CODE_SUCCESS;
    }
}
