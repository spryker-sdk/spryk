<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Style;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

class SprykStyle implements SprykStyleInterface
{
    use InputHelper;

    /**
     * @var int
     */
    public const MAX_LINE_LENGTH = 120;

    /**
     * @var int
     */
    protected $lineLength;

    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        $width = (new Terminal())->getWidth() ?: static::MAX_LINE_LENGTH;
        $this->lineLength = min($width - (int)(DIRECTORY_SEPARATOR === '\\'), static::MAX_LINE_LENGTH);
    }

    /**
     * @param int $count
     *
     * @return void
     */
    protected function newLine(int $count = 1): void
    {
        $this->write(str_repeat(PHP_EOL, $count));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startSpryk(SprykDefinitionInterface $sprykDefinition): void
    {
        if (!$this->output->isVerbose()) {
            return;
        }

        $this->newLine();

        $message = sprintf('<bg=green;options=bold> Build %s Spryk</>', $sprykDefinition->getSprykName());
        $messageLengthWithoutDecoration = Helper::width(Helper::removeDecoration($this->output->getFormatter(), $message));
        $messageLength = $this->lineLength - $messageLengthWithoutDecoration;

        $this->writeln([
            sprintf('<bg=green>%s</>', str_repeat(' ', $this->lineLength)),
            sprintf('<bg=green;options=bold>%s%s</>', $message, str_pad(' ', $messageLength)),
            sprintf('<bg=green>%s</>', str_repeat(' ', $this->lineLength)),
        ]);

        $this->newLine();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endSpryk(SprykDefinitionInterface $sprykDefinition): void
    {
        if (!$this->output->isVerbose()) {
            return;
        }

        $this->newLine();

        $message = sprintf('<fg=green>%s</> build finished', $sprykDefinition->getSprykName());
        $this->writeln($message);
        $this->writeln(str_repeat('=', $this->lineLength));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startPreSpryks(SprykDefinitionInterface $sprykDefinition): void
    {
        if (!$this->output->isVerbose()) {
            return;
        }

        $message = sprintf('<fg=green>%s</> has preSpryks', $sprykDefinition->getSprykName());

        $hasPreSpryks = (count($sprykDefinition->getPreSpryks()) > 0);
        if (!$hasPreSpryks) {
            $message = sprintf('<fg=green>%s</> has no preSpryks', $sprykDefinition->getSprykName());
        }
        $this->writeln($message);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endPreSpryks(SprykDefinitionInterface $sprykDefinition): void
    {
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startPostSpryks(SprykDefinitionInterface $sprykDefinition): void
    {
        if (!$this->output->isVerbose()) {
            return;
        }

        $message = sprintf('<fg=green>%s</> has postSpryks', $sprykDefinition->getSprykName());

        $hasPostSpryks = (count($sprykDefinition->getPostSpryks()) > 0);
        if (!$hasPostSpryks) {
            $message = sprintf('<fg=green>%s</> has no postSpryks', $sprykDefinition->getSprykName());
        }
        $this->writeln($message);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endPostSpryks(SprykDefinitionInterface $sprykDefinition): void
    {
    }

    /**
     * @param array<string>|string $messages
     * @param int $options
     *
     * @return void
     */
    public function write($messages, int $options = 0): void
    {
        $this->output->write($messages, false, $options);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function report(string $message): void
    {
        $this->output->writeln($message);
    }

    /**
     * @param string $message
     *
     * @return void
     */
    public function commandsEventReport(string $message): void
    {
        $this->writeln(sprintf('<options=bold>-- %s --</>', $message));
    }

    /**
     * @param string $commandName
     *
     * @return void
     */
    public function successCommandReport(string $commandName): void
    {
        $this->output->writeln(sprintf('<fg=green>%s</> command finished successfully.', $commandName));
    }

    /**
     * @param string $commandName
     * @param string $errorMessage
     * @param string $fallbackMessage
     *
     * @return void
     */
    public function errorCommandReport(string $commandName, string $errorMessage, string $fallbackMessage): void
    {
        $this->output->writeln([
            sprintf('<fg=red>%s</> command failed with message:', $commandName),
            sprintf('<bg=red>%s</>', $errorMessage),
            sprintf('<bg=yellow>%s</>', $fallbackMessage),
        ]);
    }

    /**
     * @param string $commandName
     *
     * @return void
     */
    public function warningCommandReport(string $commandName): void
    {
        $this->output->writeln(
            sprintf('<fg=yellow>%s</> command cannot be run for the current Spryk configuration.', $commandName),
        );
    }

    /**
     * @param array<string>|string $messages
     * @param int $options
     *
     * @return void
     */
    public function writeln($messages, int $options = 0): void
    {
        $this->output->writeln($messages, $options);
    }

    /**
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    public function getInput(): InputInterface
    {
        return $this->input;
    }
}
