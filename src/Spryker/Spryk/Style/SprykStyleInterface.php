<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Style;

use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startSpryk(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endSpryk(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startPreSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endPreSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startPostSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endPostSpryks(SprykDefinitionInterface $sprykDefinition): void;

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

    /**
     * @param string $message
     *
     * @return void
     */
    public function report(string $message): void;
}
