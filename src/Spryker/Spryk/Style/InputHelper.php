<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Style;

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
     * @return string
     */
    public function askQuestion(Question $question): string
    {
        $questionHelper = new SymfonyQuestionHelper();

        return $questionHelper->ask($this->input, $this->output, $question);
    }
}
