<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigFilterExtension extends AbstractExtension
{
    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface>
     */
    protected $filters;

    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface> $filters
     */
    public function __construct(array $filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return array<\Twig\TwigFilter>
     */
    public function getFilters(): array
    {
        $filters = [];
        foreach ($this->filters as $filter) {
            $filters[] = new TwigFilter($filter->getName(), function (string $value) use ($filter) {
                return $filter->filter($value);
            });
        }

        return $filters;
    }
}
