<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use SimpleXMLElement;
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
        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath($sprykDefinition));
        $simpleXMLElement = $resolved->getSimpleXmlElement();

        $transferName = $this->getTransferName($sprykDefinition);

        $transferXMLElement = $this->findTransferByName($simpleXMLElement, $transferName);

        if (!$transferXMLElement) {
            $style->report(sprintf('Could not find transferXMLElement by name <fg=green>%s</> in <fg=green>%s</>', $transferName, $this->getTargetPath($sprykDefinition)));

            return;
        }

        $properties = $this->getProperties($sprykDefinition);

        if ($properties) {
            foreach ($properties as $propertyParts) {
                $propertyDefinition = explode(':', trim($propertyParts));
                $this->addProperty($transferXMLElement, $transferName, $style, $propertyDefinition[0], $propertyDefinition[1], $propertyDefinition[2] ?? null);
            }

            return;
        }

        $propertyName = $this->getPropertyName($sprykDefinition);
        $propertyType = $this->getPropertyType($sprykDefinition);
        $singular = $this->getSingular($sprykDefinition);

        $this->addProperty($transferXMLElement, $transferName, $style, $propertyName, $propertyType, $singular);
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
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $output
     * @param string $propertyName
     * @param string $propertyType
     * @param string|null $singular
     *
     * @return void
     */
    protected function addProperty(
        SimpleXMLElement $transferXMLElement,
        string $transferName,
        SprykStyleInterface $output,
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

        $output->report(sprintf('Added transferXMLElement property <fg=green>%s.%s</>', $transferName, $propertyName));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array|null
     */
    protected function getProperties(SprykDefinitionInterface $sprykDefinition): ?array
    {
        $properties = $sprykDefinition
            ->getArgumentCollection()
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
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath($sprykDefinition));
        $simpleXMLElement = $resolved->getSimpleXmlElement();

        $transferName = $this->getTransferName($sprykDefinition);
        $propertyName = $this->getPropertyName($sprykDefinition);

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
