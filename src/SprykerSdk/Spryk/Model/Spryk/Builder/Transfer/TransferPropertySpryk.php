<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use DOMDocument;
use DOMElement;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class TransferPropertySpryk extends AbstractTransferSpryk
{
    /**
     * @var string
     */
    public const PROPERTY_TYPE = 'propertyType';

    /**
     * @var string
     */
    public const PROPERTY_NAME = 'propertyName';

    /**
     * @var string
     */
    public const SINGULAR = 'singular';

    /**
     * @var string
     */
    protected const SPRYK_NAME = 'transferProperty';

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return !$this->isTransferPropertyDefined($sprykDefinition);
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
        $propertyName = $this->getPropertyName($sprykDefinition);
        $propertyType = $this->getPropertyType($sprykDefinition);
        $singular = $this->getSingular($sprykDefinition);

        $xmlSchemaDom = $this->getDomDocument($targetPath);

        $transfer = $this->findTransferByName($transferName, $xmlSchemaDom);

        if (!$transfer) {
            $style->report(sprintf('Could not find transfer by name <fg=green>%s</> in <fg=green>%s</>', $transferName, $targetPath));

            return;
        }

        $property = $this->findPropertyByName($propertyName, $transfer);

        if ($property) {
            $style->report(sprintf('A property by name <fg=green>%s.%s</> already exists in <fg=green>%s</>', $transferName, $propertyName, $targetPath));

            return;
        }

        $transfer->appendChild($this->createProperty($xmlSchemaDom, $propertyName, $propertyType, $singular));

        /** @var string $xmlString */
        $xmlString = $xmlSchemaDom->saveXML();

        $this->writeXml($xmlString, $targetPath);

        $style->report(sprintf('Added transfer property <fg=green>%s.%s</> in <fg=green>%s</>', $transferName, $propertyName, $targetPath));
    }

    /**
     * @param string $propertyName
     * @param \DOMElement $transfer
     *
     * @return \DOMElement|null
     */
    protected function findPropertyByName(string $propertyName, DOMElement $transfer): ?DOMElement
    {
        $properties = $transfer->getElementsByTagName('property');

        foreach ($properties as $property) {
            if ($property->getAttribute('name') === $propertyName) {
                return $property;
            }
        }

        return null;
    }

    /**
     * @param \DOMDocument $xmlSchemaDom
     * @param string $propertyName
     * @param string $propertyType
     * @param string|null $singular
     *
     * @return \DOMElement
     */
    protected function createProperty(DOMDocument $xmlSchemaDom, string $propertyName, string $propertyType, ?string $singular): DOMElement
    {
        $property = $xmlSchemaDom->createElement('property');

        $property->setAttribute('name', $propertyName);
        $property->setAttribute('type', $propertyType);

        if (is_string($singular)) {
            $property->setAttribute('singular', $singular);
        }

        return $property;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getPropertyName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::PROPERTY_NAME)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getPropertyType(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::PROPERTY_TYPE)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string|null
     */
    protected function getSingular(SprykDefinitionInterface $sprykDefinition): ?string
    {
        $singular = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::SINGULAR)
            ->getValue();

        if ($singular) {
            return $singular;
        }

        return null;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isTransferPropertyDefined(SprykDefinitionInterface $sprykDefinition): bool
    {
        $targetPath = $this->getTargetPath($sprykDefinition);
        $transferName = $this->getTransferName($sprykDefinition);
        $propertyName = $this->getPropertyName($sprykDefinition);

        $xmlSchemaDom = $this->getDomDocument($targetPath);

        $transfer = $this->findTransferByName($transferName, $xmlSchemaDom);

        if (!$transfer) {
            return false;
        }

        $property = $this->findPropertyByName($propertyName, $transfer);

        if (!$property) {
            return false;
        }

        return true;
    }
}
