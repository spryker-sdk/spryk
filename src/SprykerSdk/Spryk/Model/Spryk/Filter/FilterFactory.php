<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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
            $this->createCamelBackFilter(),
            $this->createClassNameShortFilter(),
            $this->createEnsureControllerSuffixFilter(),
            $this->createRemoveControllerSuffixFilter(),
            $this->createRemoveActionSuffixFilter(),
            $this->createDasherizeFilter(),
            $this->createUnderscoreFilter(),
            $this->createCamelCaseFilter(),
            $this->createLowerCaseFirstFilter(),
            $this->createCamelCaseToWhitespaceFilter(),
        ];
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
}
