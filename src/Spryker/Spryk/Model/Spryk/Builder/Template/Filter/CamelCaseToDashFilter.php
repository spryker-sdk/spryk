<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Filter;

use Twig\TwigFilter;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToDash;

class CamelCaseToDashFilter extends TwigFilter
{
    public function __construct()
    {
        parent::__construct('camelCaseToDash', $this->getCallback());
    }

    /**
     * @return \Closure
     */
    protected function getCallback()
    {
        return function (string $string) {
            $filterChain = new FilterChain();
            $filterChain->attach(new CamelCaseToDash())
                ->attach(new StringToLower());

            return $filterChain->filter($string);
        };
    }
}
