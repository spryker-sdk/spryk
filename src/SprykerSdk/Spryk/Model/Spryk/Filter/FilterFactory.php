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
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface>
     */
    public function getFilterCollection(): array
    {
        return [
            $this->createArgumentToDocParameterFilter(),
            $this->createCamelCaseFilter(),
            $this->createCamelCaseToWhitespaceFilter(),
            $this->createClassNameShortFilter(),
            $this->createConvertToClassNameFragmentFilter(),
            $this->createDasherizeFilter(),
            $this->createDashToCamelCaseFilter(),
            $this->createDashToUnderscoreFilter(),
            $this->createEnsureConsoleSuffixFilter(),
            $this->createEnsureControllerSuffixFilter(),
            $this->createEnsureMapperSuffixFilter(),
            $this->createLowerCaseFirstFilter(),
            $this->createRemoveActionSuffixFilter(),
            $this->createRemoveControllerSuffixFilter(),
            $this->createRemoveConfigSuffixFilter(),
            $this->createRemoveRestApiSuffixFilter(),
            $this->createRemoveWidgetSuffixFilter(),
            $this->createSingularizeFilter(),
            $this->createTypedArrayFilter(),
            $this->createUnderscoreFilter(),
            $this->createUpperCaseFirstFilter(),
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
    public function createRemoveConfigSuffixFilter(): FilterInterface
    {
        return new RemoveConfigSuffixFilter();
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
    public function createRemoveWidgetSuffixFilter(): FilterInterface
    {
        return new RemoveWidgetSuffixFilter();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    public function createUpperCaseFirstFilter(): FilterInterface
    {
        return new UpperCaseFirstFilter();
    }
}
