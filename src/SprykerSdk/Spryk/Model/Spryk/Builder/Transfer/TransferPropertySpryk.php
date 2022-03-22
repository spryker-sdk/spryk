<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use SimpleXMLElement;

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
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());
        $simpleXMLElement = $resolved->getSimpleXmlElement();

        $transferName = $this->getTransferName();

        $transferXMLElement = $this->findTransferByName($simpleXMLElement, $transferName);

        if (!$transferXMLElement) {
            $this->log(sprintf('Could not find transferXMLElement by name <fg=green>%s</> in <fg=green>%s</>', $transferName, $this->getTargetPath()));

            return;
        }

        $properties = $this->getProperties();

        if ($properties) {
            foreach ($properties as $propertyParts) {
                $propertyDefinition = explode(':', trim($propertyParts));
                $this->addProperty($transferXMLElement, $transferName, $propertyDefinition[0], $propertyDefinition[1], $propertyDefinition[2] ?? null);
            }

            return;
        }

        $propertyName = $this->getPropertyName();
        $propertyType = $this->getPropertyType();
        $singular = $this->getSingular();

        $this->addProperty($transferXMLElement, $transferName, $propertyName, $propertyType, $singular);
    }

    /**
     * @param \SimpleXMLElement $transferXMLElement
     * @param string $propertyName
     *
     * @return \SimpleXMLElement|null
     */
    protected function findPropertyByName(SimpleXMLElement $transferXMLElement, string $propertyName): ?SimpleXMLElement
    {
        foreach ($transferXMLElement->children() as $propertyXMLElement) {
            if ((string)$propertyXMLElement['name'] === $propertyName) {
                return $propertyXMLElement;
            }
        }

        return null;
    }

    /**
     * @param \SimpleXMLElement $transferXMLElement
     * @param string $transferName
     * @param string $propertyName
     * @param string $propertyType
     * @param string|null $singular
     *
     * @return void
     */
    protected function addProperty(
        SimpleXMLElement $transferXMLElement,
        string $transferName,
        string $propertyName,
        string $propertyType,
        ?string $singular = null
    ): void {
        $propertyXMLElement = $this->findPropertyByName($transferXMLElement, $propertyName);

        if ($propertyXMLElement) {
            return;
        }

        $propertyXMLElement = $transferXMLElement->addChild('property');
        $propertyXMLElement->addAttribute('name', $propertyName);
        $propertyXMLElement->addAttribute('type', $propertyType);

        if ($singular) {
            $propertyXMLElement->addAttribute('singular', $singular);
        }

        $this->log(sprintf('Added transferXMLElement property <fg=green>%s.%s</>', $transferName, $propertyName));
    }

    /**
     * @return array|null
     */
    protected function getProperties(): ?array
    {
        $properties = $this->arguments
            ->getArgument(static::PROPERTY_NAME)
            ->getValue();

        if (is_array($properties)) {
            return $properties;
        }

        if (strpos($properties, ',') !== false) {
            return explode(',', $properties);
        }

        return null;
    }

    /**
     * @return string
     */
    protected function getPropertyName(): string
    {
        return $this->getStringArgument(static::PROPERTY_NAME);
    }

    /**
     * @return string
     */
    protected function getPropertyType(): string
    {
        return $this->getStringArgument(static::PROPERTY_TYPE);
    }

    /**
     * @return string|null
     */
    protected function getSingular(): ?string
    {
        $singular = $this->arguments->getArgument(static::SINGULAR)->getValue();

        if ($singular) {
            return $singular;
        }

        return null;
    }

    /**
     * @return bool
     */
    protected function isTransferPropertyDefined(): bool
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());
        $simpleXMLElement = $resolved->getSimpleXmlElement();

        $transferName = $this->getTransferName();
        $propertyName = $this->getPropertyName();

        $transferXMLElement = $this->findTransferByName($simpleXMLElement, $transferName);

        if (!$transferXMLElement) {
            return false;
        }

        $propertyXMLElement = $this->findPropertyByName($transferXMLElement, $propertyName);

        if (!$propertyXMLElement) {
            return false;
        }

        return true;
    }
}
