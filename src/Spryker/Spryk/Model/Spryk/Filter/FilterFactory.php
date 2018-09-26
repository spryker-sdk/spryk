<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Filter;

class FilterFactory
{
    /**
     * @return \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createCamelBackFilter(): FilterInterface
    {
        return new CamelBackFilter();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createClassNameShortFilter(): FilterInterface
    {
        return new ClassNameShortFilter();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createControllerNameFilter(): FilterInterface
    {
        return new ControllerNameFilter();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createDasherizeFilter(): FilterInterface
    {
        return new DasherizeFilter();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createUnderscoreFilter(): FilterInterface
    {
        return new UnderscoreFilter();
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createCamelCaseFilter(): FilterInterface
    {
        return new CamelCaseFilter();
    }
}
