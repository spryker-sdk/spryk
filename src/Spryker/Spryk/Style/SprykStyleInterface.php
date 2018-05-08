<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Style;

use Symfony\Component\Console\Question\Question;

interface SprykStyleInterface
{
    const VERBOSITY_QUIET = 16;
    const VERBOSITY_NORMAL = 32;
    const VERBOSITY_VERBOSE = 64;
    const VERBOSITY_VERY_VERBOSE = 128;
    const VERBOSITY_DEBUG = 256;

    const OUTPUT_NORMAL = 1;
    const OUTPUT_RAW = 2;
    const OUTPUT_PLAIN = 4;

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function startProcess(string $sprykName): void;

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function endProcess(string $sprykName): void;

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function startSpryk(string $sprykName): void;

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function endSpryk(string $sprykName): void;

    /**
     * @param string $sprykName
     *
     * @return void
     */
    public function dryRunSpryk(string $sprykName): void;

    /**
     * @param string $output
     *
     * @return void
     */
    public function note(string $output): void;

    /**
     * @param int $count
     *
     * @return void
     */
    public function newLine(int $count = 1): void;

    /**
     * @param string|array $messages
     * @param int $options
     *
     * @return void
     */
    public function write($messages, int $options = 0): void;

    /**
     * @param \Symfony\Component\Console\Question\Question $question
     *
     * @return string
     */
    public function askQuestion(Question $question): string;
}
