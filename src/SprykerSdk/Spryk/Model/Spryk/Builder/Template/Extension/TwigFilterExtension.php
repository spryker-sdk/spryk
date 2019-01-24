<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template\Extension;

use Twig\Extension\AbstractExtension;
use Twig_SimpleFilter;

class TwigFilterExtension extends AbstractExtension
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface[]
     */
    protected $filters;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface[] $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return \Twig_SimpleFilter[]
     */
    public function getFilters(): array
    {
        $filters = [];
        foreach ($this->filters as $filter) {
            $filters[] = new Twig_SimpleFilter($filter->getName(), function (string $value) use ($filter) {
                return $filter->filter($value);
            });
        }

        return $filters;
    }
}
