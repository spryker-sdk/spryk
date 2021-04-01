<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use DOMDocument;
use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\DashToCamelCase;
use SimpleXMLElement;
use SprykerSdk\Spryk\Exception\XmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class TransferSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET_PATH = 'targetPath';
    public const ARGUMENT_NAME = 'name';
    protected const SPRYK_NAME = 'transfer';

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
        $xml = $this->getXml($sprykDefinition);

        $dashToCamelCaseFilter = $this->getDashToCamelCase();

        $transferName = $dashToCamelCaseFilter->filter($this->getArgumentName($sprykDefinition));

        $transfers = $xml[0];
        if (!$transfers) {
            return;
        }

        $transfers->addChild('transfer', ' ')
            ->addAttribute('name', $transferName);

        $this->prettyPrintXml($xml, $sprykDefinition);

        $style->report(sprintf('Added transfer in <fg=green>%s</>', $this->getTargetPath($sprykDefinition)));
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
        $dom = new DOMDocument('1.0');
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
    protected function getArgumentName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_NAME)
            ->getValue();
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

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isTransferDefined(SprykDefinitionInterface $sprykDefinition): bool
    {
        $xml = $this->getXml($sprykDefinition);
        $dashToCamelCaseFilter = $this->getDashToCamelCase();
        $transferName = $dashToCamelCaseFilter->filter($this->getArgumentName($sprykDefinition));
        $transferPattern = sprintf('/<transfer (.*)?name="%s"/', $transferName);

        $xmlString = $xml->asXML();
        if (!is_string($xmlString)) {
            return false;
        }

        return (bool)preg_match($transferPattern, $xmlString);
    }
}
