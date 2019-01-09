<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Style;

use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

interface SprykStyleInterface
{
    public const VERBOSITY_QUIET = 16;
    public const VERBOSITY_NORMAL = 32;
    public const VERBOSITY_VERBOSE = 64;
    public const VERBOSITY_VERY_VERBOSE = 128;
    public const VERBOSITY_DEBUG = 256;

    public const OUTPUT_NORMAL = 1;
    public const OUTPUT_RAW = 2;
    public const OUTPUT_PLAIN = 4;

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
     * @return string|int|null
     */
    public function askQuestion(Question $question);

    /**
     * @param string $message
     *
     * @return void
     */
    public function report(string $message): void;

    /**
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    public function getInput(): InputInterface;
}
