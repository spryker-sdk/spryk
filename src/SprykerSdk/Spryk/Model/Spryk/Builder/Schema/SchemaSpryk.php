<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Schema;

use DOMDocument;
use SimpleXMLElement;
use SprykerSdk\Spryk\Exception\XmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class SchemaSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET_PATH = 'targetPath';
    public const ARGUMENT_TABLE_NAME = 'tableName';

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    protected $filter;

    /**
     * @param string $rootDirectory
     * @param \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface $filter
     */
    public function __construct(string $rootDirectory, FilterInterface $filter)
    {
        $this->rootDirectory = $rootDirectory;
        $this->filter = $filter;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'schema';
    }

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
        $simpleXmlElement = $this->getSimpleXmlElement($sprykDefinition);

        $tableName = $this->getTableName($sprykDefinition);
        if ($this->isTableDefinedInSchema($simpleXmlElement, $tableName)) {
            return;
        }

        $tableNodeXmlElement = $simpleXmlElement->addChild('table');
        $tableNodeXmlElement->addAttribute('name', $tableName);
        $tableNodeXmlElement->addAttribute('idMethod', 'native');
        $tableNodeXmlElement->addAttribute('class', $this->filter->filter($tableName));

        $this->prettyPrintXml($simpleXmlElement, $sprykDefinition);

        $style->report(sprintf('Added table to <fg=green>%s</>', $this->getTargetPath($sprykDefinition)));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \SimpleXMLElement
     */
    protected function getSimpleXmlElement(SprykDefinitionInterface $sprykDefinition): SimpleXMLElement
    {
        $simpleXMLElement = $this->loadXmlFromFile($sprykDefinition);

        return $simpleXMLElement;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\XmlException
     *
     * @return \SimpleXMLElement
     */
    protected function loadXmlFromFile(SprykDefinitionInterface $sprykDefinition)
    {
        $targetPath = $this->getTargetPath($sprykDefinition);

        $simpleXMLElement = simplexml_load_file($targetPath);

        if (!($simpleXMLElement instanceof SimpleXMLElement)) {
            throw new XmlException('Could not load xml file!');
        }

        return $simpleXMLElement;
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
    protected function getTableName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TABLE_NAME)
            ->getValue();
    }

    /**
     * @param \SimpleXMLElement $simpleXmlElement
     * @param string $tableName
     *
     * @return bool
     */
    protected function isTableDefinedInSchema(SimpleXMLElement $simpleXmlElement, string $tableName): bool
    {
        $tableXmlElements = $simpleXmlElement->xpath('//table');
        if ($tableXmlElements !== false) {
            foreach ($tableXmlElements as $tableXmlElement) {
                if ((string)$tableXmlElement['name'] === $tableName) {
                    return true;
                }
            }
        }

        return false;
    }
}
