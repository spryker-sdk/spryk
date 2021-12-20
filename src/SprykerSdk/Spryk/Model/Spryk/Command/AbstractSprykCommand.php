<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Command;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Process\Process;

abstract class AbstractSprykCommand implements SprykCommandInterface
{
    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function execute(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        if (!$this->isRunnable($sprykDefinition)) {
            $style->warningCommandReport($this->getName());

            return;
        }

        $process = new Process(explode(' ', $this->getCommandLine()), APPLICATION_ROOT_DIR);
        $process->run();

        if (!$process->isSuccessful()) {
            $style->errorCommandReport(
                $this->getName(),
                $this->getProcessErrorOutput($process),
                $this->getFallbackMessage($sprykDefinition),
            );

            return;
        }

        $style->successCommandReport($this->getName());
    }

    /**
     * @param \Symfony\Component\Process\Process $process
     *
     * @return string
     */
    protected function getProcessErrorOutput(Process $process): string
    {
        if ($process->getErrorOutput()) {
            return $process->getErrorOutput();
        }

        $firstLinesOfOutput = array_filter(array_slice(explode("\n", $process->getOutput()), 0, 3));
        $firstLinesOfOutput[] = '...';

        return implode("\n", $firstLinesOfOutput);
    }

    /**
     * @return string
     */
    abstract protected function getCommandLine(): string;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    abstract protected function isRunnable(SprykDefinitionInterface $sprykDefinition): bool;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    abstract protected function getFallbackMessage(SprykDefinitionInterface $sprykDefinition): string;
}
