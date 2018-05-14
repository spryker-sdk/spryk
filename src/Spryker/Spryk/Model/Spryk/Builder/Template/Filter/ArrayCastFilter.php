<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Filter;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Argument;
use Twig\TwigFilter;

class ArrayCastFilter extends TwigFilter
{
    public function __construct()
    {
        parent::__construct('array', $this->getCallback());
    }

    /**
     * @return \Closure
     */
    protected function getCallback()
    {
        return function ($input) {
            if ($input instanceof Argument) {
                $input = $input->getValue();
            }
            $filtered = (array)$input;

            return $filtered;
        };
    }
}
