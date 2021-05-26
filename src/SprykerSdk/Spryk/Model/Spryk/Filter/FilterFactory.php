<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Filter;

use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Extension\TwigFilterExtension;
use Twig\Extension\ExtensionInterface;

class FilterFactory
{
    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface[]
     */
    public function getFilterCollection(): array
    {
        return [
            $this->createArgumentToDocParameterFilter(),
            $this->createCamelBackFilter(),
            $this->createClassNameShortFilter(),
            $this->createEnsureControllerSuffixFilter(),
            $this->createEnsureConsoleSuffixFilter(),
            $this->createEnsureMapperSuffixFilter(),
            $this->createRemoveControllerSuffixFilter(),
            $this->createRemoveActionSuffixFilter(),
            $this->createDasherizeFilter(),
            $this->createUnderscoreFilter(),
            $this->createCamelCaseFilter(),
            $this->createLowerCaseFirstFilter(),
            $this->createCamelCaseToWhitespaceFilter(),
            $this->createConvertToClassNameFragmentFilter(),
            $this->createDashToCamelCaseFilter(),
            $this->createDashToUnderscoreFilter(),
            $this->createSingularizeFilter(),
            $this->createTypedArrayFilter(),
            $this->createRemoveRestApiSuffixFilter(),
            $this->createCamelCaseToDashFilter(),
            $this->createRemoveWidgetSuffixFilter(),
            $this->createLowerCaseFilter(),
            $this->createUpperCaseFirstFilter(),
            $this->createUpperCaseFilter(),
        ];
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createArgumentToDocParameterFilter(): FilterInterface
    {
        return new ArgumentToDocParameterFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Extension\TwigFilterExtension|\Twig\Extension\ExtensionInterface
     */
    public function createFilterExtension(): ExtensionInterface
    {
        return new TwigFilterExtension($this->getFilterCollection());
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createCamelBackFilter(): FilterInterface
    {
        return new CamelBackFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createClassNameShortFilter(): FilterInterface
    {
        return new ClassNameShortFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createEnsureControllerSuffixFilter(): FilterInterface
    {
        return new EnsureControllerSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createEnsureConsoleSuffixFilter(): FilterInterface
    {
        return new EnsureConsoleSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createEnsureMapperSuffixFilter(): FilterInterface
    {
        return new EnsureMapperSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createRemoveControllerSuffixFilter(): FilterInterface
    {
        return new RemoveControllerSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createRemoveActionSuffixFilter(): FilterInterface
    {
        return new RemoveActionSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createDasherizeFilter(): FilterInterface
    {
        return new DasherizeFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createUnderscoreFilter(): FilterInterface
    {
        return new UnderscoreFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createCamelCaseFilter(): FilterInterface
    {
        return new CamelCaseFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createLowerCaseFirstFilter(): FilterInterface
    {
        return new LowerCaseFirstFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createCamelCaseToWhitespaceFilter(): FilterInterface
    {
        return new CamelCaseToWhitespaceFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createConvertToClassNameFragmentFilter(): FilterInterface
    {
        return new ConvertToClassNameFragmentFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createDashToCamelCaseFilter(): FilterInterface
    {
        return new DashToCamelCaseFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createDashToUnderscoreFilter(): FilterInterface
    {
        return new DashToUnderscoreFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createSingularizeFilter(): FilterInterface
    {
        return new SingularizeFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createTypedArrayFilter(): FilterInterface
    {
        return new TypedArrayFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createRemoveRestApiSuffixFilter(): FilterInterface
    {
        return new RemoveRestApiSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createCamelCaseToDashFilter(): FilterInterface
    {
        return new CamelCaseToDashFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createRemoveWidgetSuffixFilter(): FilterInterface
    {
        return new RemoveWidgetSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createLowerCaseFilter(): FilterInterface
    {
        return new LowerCaseFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createUpperCaseFirstFilter(): FilterInterface
    {
        return new UpperCaseFirstFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createUpperCaseFilter(): FilterInterface
    {
        return new UpperCaseFilter();
    }
}
