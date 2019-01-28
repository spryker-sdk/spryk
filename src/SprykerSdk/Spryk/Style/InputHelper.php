<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Style;

use Symfony\Component\Console\Helper\SymfonyQuestionHelper;
use Symfony\Component\Console\Question\Question;

trait InputHelper
{
    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    protected $input;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
     */
    protected $output;

    /**
     * @param \Symfony\Component\Console\Question\Question $question
     *
     * @return string|int|null
     */
    public function askQuestion(Question $question)
    {
        $questionHelper = new SymfonyQuestionHelper();

        return $questionHelper->ask($this->input, $this->output, $question);
    }
}
