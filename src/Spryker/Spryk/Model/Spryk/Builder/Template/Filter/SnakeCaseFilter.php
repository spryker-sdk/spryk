<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Filter;

use Twig\TwigFilter;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToUnderscore;

class SnakeCaseFilter extends TwigFilter
{
    public function __construct()
    {
        parent::__construct('snakeCase', $this->getCallback());
    }

    /**
     * @return \Closure
     */
    protected function getCallback()
    {
        return function (string $string) {
            $filterChain = new FilterChain();
            $filterChain->attach(new CamelCaseToUnderscore())
                ->attach(new StringToLower());

            return $filterChain->filter($string);
        };
    }
}
