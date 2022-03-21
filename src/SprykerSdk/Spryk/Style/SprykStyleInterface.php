<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Style;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

interface SprykStyleInterface
{
    /**
     * @var int
     */
    public const VERBOSITY_QUIET = 16;

    /**
     * @var int
     */
    public const VERBOSITY_NORMAL = 32;

    /**
     * @var int
     */
    public const VERBOSITY_VERBOSE = 64;

    /**
     * @var int
     */
    public const VERBOSITY_VERY_VERBOSE = 128;

    /**
     * @var int
     */
    public const VERBOSITY_DEBUG = 256;

    /**
     * @var int
     */
    public const OUTPUT_NORMAL = 1;

    /**
     * @var int
     */
    public const OUTPUT_RAW = 2;

    /**
     * @var int
     */
    public const OUTPUT_PLAIN = 4;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startSpryk(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endSpryk(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startPreSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endPreSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function startPostSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    public function endPostSpryks(SprykDefinitionInterface $sprykDefinition): void;

    /**
     * @param array<string>|string $messages
     * @param int $options
     *
     * @return void
     */
    public function write($messages, int $options = 0): void;

    /**
     * @param array<string>|string $messages
     * @param int $options
     *
     * @return void
     */
    public function writeln($messages, int $options = 0): void;

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
     * @param string $message
     *
     * @return void
     */
    public function commandsEventReport(string $message): void;

    /**
     * @param string $commandName
     *
     * @return void
     */
    public function successCommandReport(string $commandName): void;

    /**
     * @param string $commandName
     * @param string $errorMessage
     * @param string $fallbackMessage
     *
     * @return void
     */
    public function errorCommandReport(string $commandName, string $errorMessage, string $fallbackMessage): void;

    /**
     * @param string $commandName
     *
     * @return void
     */
    public function warningCommandReport(string $commandName): void;

    /**
     * @return \Symfony\Component\Console\Input\InputInterface
     */
    public function getInput(): InputInterface;
}
