<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

class TransferSpryk extends AbstractTransferSpryk
{
    /**
     * @var string
     */
    protected const SPRYK_NAME = 'transfer';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::SPRYK_NAME;
    }

    /**
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        return !$this->isTransferDefined();
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        $transferName = $this->getTransferName();

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());
        $simpleXmlElement = $resolved->getSimpleXmlElement();

        $transferNodeXmlElement = $simpleXmlElement->addChild('transfer');
        $transferNodeXmlElement->addAttribute('name', $transferName);

        $resolved->setSimpleXmlElement($simpleXmlElement);

        $this->log(sprintf('Added transfer in <fg=green>%s</>', $this->getTargetPath()));
    }

    /**
     * @return bool
     */
    protected function isTransferDefined(): bool
    {
        $transferName = $this->getTransferName();

        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());
        $simpleXmlElement = $resolved->getSimpleXmlElement();

        $transferXMLElement = $this->findTransferByName($simpleXmlElement, $transferName);

        if (!$transferXMLElement) {
            return false;
        }

        return true;
    }
}
