<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Filter;

use Twig\TwigFilter;

class ClassNameShortFiler extends TwigFilter
{
    public function __construct()
    {
        parent::__construct('classNameShort', $this->getCallback());
    }

    /**
     * @return \Closure
     */
    protected function getCallback()
    {
        return function (string $string) {
            $classNameFragments = explode('\\', $string);

            return array_pop($classNameFragments);
        };
    }
}
