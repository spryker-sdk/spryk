<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use DOMDocument;
use DOMElement;
use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\DashToCamelCase;
use SimpleXMLElement;
use SprykerSdk\Spryk\Exception\XmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

abstract class AbstractTransferSpryk implements SprykBuilderInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_TARGET_PATH = 'targetPath';

    /**
     * @var string
     */
    public const ARGUMENT_NAME = 'name';

    /**
     * @var string
     */
    protected const SPRYK_NAME = 'implemented by derived classes';

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @param string $rootDirectory
     */
    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
    }

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
    abstract public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    abstract public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void;

    /**
     * @param string $xmlFilePath
     *
     * @return \DOMDocument
     */
    protected function getDomDocument(string $xmlFilePath): DOMDocument
    {
        $xmlSchemaDom = new DOMDocument('1.0');
        $xmlSchemaDom->formatOutput = true;
        $xmlSchemaDom->preserveWhiteSpace = false;
        $xmlSchemaDom->load($xmlFilePath);

        return $xmlSchemaDom;
    }

    /**
     * @param string $xml
     * @param string $targetPath
     *
     * @return void
     */
    protected function writeXml(string $xml, string $targetPath): void
    {
        $xml = str_replace('</transfer>', '</transfer>' . PHP_EOL, $xml);

        file_put_contents($targetPath, $xml);
    }

    /**
     * @param string $transferName
     * @param \DOMDocument $xmlSchemaDom
     *
     * @return \DOMElement|null
     */
    protected function findTransferByName(string $transferName, DOMDocument $xmlSchemaDom): ?DOMElement
    {
        $transfers = $xmlSchemaDom->getElementsByTagName('transfer');

        /** @var \DOMElement $transfer */
        foreach ($transfers as $transfer) {
            if ($transfer->getAttribute('name') !== $transferName) {
                continue;
            }

            return $transfer;
        }

        return null;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\XmlException
     *
     * @return \SimpleXMLElement
     */
    protected function getXml(SprykDefinitionInterface $sprykDefinition): SimpleXMLElement
    {
        $xml = $this->loadXmlFromFile($sprykDefinition);

        if (!($xml instanceof SimpleXMLElement)) {
            throw new XmlException('Could not load xml file!');
        }

        return $xml;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \SimpleXMLElement|false
     */
    protected function loadXmlFromFile(SprykDefinitionInterface $sprykDefinition)
    {
        $targetPath = $this->getTargetPath($sprykDefinition);

        return simplexml_load_file($targetPath);
    }

    /**
     * @param \SimpleXMLElement $xml
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return void
     */
    protected function prettyPrintXml(SimpleXMLElement $xml, SprykDefinitionInterface $sprykDefinition): void
    {
        $dom = new DOMDocument('1.1');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        $dom->loadXML($this->getXmlAsString($xml));
        $dom->save($this->getTargetPath($sprykDefinition));
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SimpleXMLElement $xml
     *
     * @throws \SprykerSdk\Spryk\Exception\XmlException
     *
     * @return string
     */
    protected function getXmlAsString(SimpleXMLElement $xml): string
    {
        $xmlString = $xml->asXML();

        if (!is_string($xmlString)) {
            throw new XmlException('Could not get xml as string!');
        }

        return $xmlString;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->rootDirectory . $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTransferName(SprykDefinitionInterface $sprykDefinition): string
    {
        $dashToCamelCaseFilter = $this->getDashToCamelCase();

        $transferName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_NAME)
            ->getValue();

        return $dashToCamelCaseFilter->filter($transferName);
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
