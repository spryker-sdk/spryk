<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template\Filter;

use Spryker\Spryk\Model\Spryk\Filter\FilterInterface;
use Twig\TwigFilter;

class TemplateFilter extends TwigFilter
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    protected $filter;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Filter\FilterInterface $filter
     * @param string $filterName
     */
    public function __construct(FilterInterface $filter, string $filterName)
    {
        parent::__construct($filterName, $this->getCallback($filter));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Filter\FilterInterface $filter
     *
     * @return \Closure
     */
    protected function getCallback(FilterInterface $filter)
    {
        return function (string $string) use ($filter) {
            return $filter->filter($string);
        };
    }
}
