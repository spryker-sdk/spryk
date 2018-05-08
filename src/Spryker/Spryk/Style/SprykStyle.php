<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Style;

use Symfony\Component\Console\Helper\Helper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Terminal;

class SprykStyle implements SprykStyleInterface
{
    const MAX_LINE_LENGTH = 120;

    use InputHelper;

    /**
     * @var int
     */
    protected $lineLength;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * @param \Symfony\Component\Console\Input\InputInterface $input
     * @param \Symfony\Component\Console\Output\OutputInterface $output
     */
    public function __construct(InputInterface $input, OutputInterface $output)
    {
        $width = (new Terminal())->getWidth() ?: static::MAX_LINE_LENGTH;
        $this->lineLength = min($width - (int)(DIRECTORY_SEPARATOR === '\\'), static::MAX_LINE_LENGTH);

        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @param int $count
     *
     * @return void
     */
    public function newLine(int $count = 1): void
    {
        $this->write(str_repeat(PHP_EOL, $count));
    }

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function startProcess(string $sprykName): void
    {
        $message = sprintf('Spryk <fg=green>%s</>', $sprykName);
        $messageLengthWithoutDecoration = Helper::strlenWithoutDecoration($this->output->getFormatter(), $message);
        $message = $message . str_pad(' ', $this->lineLength - $messageLengthWithoutDecoration);

        $this->writeln([
            str_repeat('=', $this->lineLength),
            $message,
            str_repeat('=', $this->lineLength),
        ]);

        $this->newLine();
    }

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function endProcess(string $sprykName): void
    {
        $message = sprintf('Spryk <fg=green>%s</> finished', $sprykName);
        $this->newLine();
        $this->writeln($message);
    }

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function startSpryk(string $sprykName): void
    {
        $message = sprintf('<bg=green;options=bold> Spryk %s</>', $sprykName);
        $messageLengthWithoutDecoration = Helper::strlenWithoutDecoration($this->output->getFormatter(), $message);
        $messageLength = $this->lineLength - $messageLengthWithoutDecoration;

        $this->writeln([
            sprintf('<bg=green>%s</>', str_repeat(' ', $this->lineLength)),
            sprintf('<bg=green;options=bold>%s%s</>', $message, str_pad(' ', $messageLength)),
            sprintf('<bg=green>%s</>', str_repeat(' ', $this->lineLength)),
        ]);

        $this->newLine();
    }

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function endSpryk(string $sprykName): void
    {
        $this->newLine();

        if ($this->output->isVerbose()) {
            $message = sprintf('Spryk <fg=green>%s</> finished', $sprykName);
            $this->writeln($message);
            $this->writeln(str_repeat('=', $this->lineLength));
            $this->newLine(3);
        }
    }

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function dryRunSpryk(string $sprykName): void
    {
        $this->newLine();
        $this->write(sprintf(' // Dry-run: Spryk <fg=green>%s</>', $sprykName));
        $this->newLine(3);
    }

    /**
     * @param string $output
     *
     * @return void
     */
    public function note(string $output): void
    {
        if ($this->output->isVeryVerbose()) {
            $this->write(' // ' . $output);
        }
    }

    /**
     * @param array|string $messages
     * @param int $options
     *
     * @return void
     */
    public function write($messages, int $options = 0): void
    {
        $this->output->write($messages, false, $options);
    }

    /**
     * @param array|string $messages
     * @param int $options
     *
     * @return void
     */
    protected function writeln($messages, int $options = 0): void
    {
        $this->output->writeln($messages, $options);
    }
}
