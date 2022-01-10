<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return !$this->isTransferDefined($sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetPath = $this->getTargetPath($sprykDefinition);
        $transferName = $this->getTransferName($sprykDefinition);

        $xmlSchemaDom = $this->getDomDocument($targetPath);

        $transfer = $xmlSchemaDom->createElement('transfer');
        $transfer->setAttribute('name', $transferName);

        /** @var \DOMElement $rootNode */
        $rootNode = $xmlSchemaDom->documentElement;
        $rootNode->appendChild($transfer);

        /** @var string $xmlString */
        $xmlString = $xmlSchemaDom->saveXML();

        $this->writeXml($xmlString, $targetPath);

        $style->report(sprintf('Added transfer in <fg=green>%s</>', $this->getTargetPath($sprykDefinition)));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isTransferDefined(SprykDefinitionInterface $sprykDefinition): bool
    {
        $targetPath = $this->getTargetPath($sprykDefinition);
        $transferName = $this->getTransferName($sprykDefinition);

        $xmlSchemaDom = $this->getDomDocument($targetPath);

        $transfer = $this->findTransferByName($transferName, $xmlSchemaDom);

        if (!$transfer) {
            return false;
        }

        return true;
    }
}
