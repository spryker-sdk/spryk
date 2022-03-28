<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\DashToCamelCase;
use SimpleXMLElement;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;

abstract class AbstractTransferSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    public const ARGUMENT_NAME = 'name';

    /**
     * @var string
     */
    protected const SPRYK_NAME = 'implemented by derived classes';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::SPRYK_NAME;
    }

    /**
     * @param \SimpleXMLElement $simpleXMLElement
     * @param string $transferName
     *
     * @return \SimpleXMLElement|null
     */
    protected function findTransferByName(SimpleXMLElement $simpleXMLElement, string $transferName): ?SimpleXMLElement
    {
        /** @var \SimpleXMLElement $transferXMLElement */
        foreach ($simpleXMLElement->children() as $transferXMLElement) {
            if ((string)$transferXMLElement['name'] === $transferName) {
                return $transferXMLElement;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getTransferName(): string
    {
        $dashToCamelCaseFilter = $this->getDashToCamelCase();

        return $dashToCamelCaseFilter->filter($this->getStringArgument(static::ARGUMENT_NAME));
    }

    /**
     * @return \Laminas\Filter\FilterChain
     */
    protected function getDashToCamelCase(): FilterChain
    {
        $filterChain = new FilterChain();
        $filterChain
            ->attach(new DashToCamelCase());

        return $filterChain;
    }
}
