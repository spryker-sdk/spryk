<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Navigation;

use DOMDocument;
use SimpleXMLElement;
use Spryker\Spryk\Exception\XmlException;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToLower;
use Zend\Filter\Word\CamelCaseToDash;

class NavigationSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET_PATH = 'targetPath';
    public const ARGUMENT_MODULE = 'module';
    public const ARGUMENT_CONTROLLER = 'controller';
    public const ARGUMENT_ACTION = 'method';

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
        return 'navigation';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $xml = $this->getXml($sprykDefinition);

        $dasherizeFilter = $this->getDasherizeFilter();

        $module = $dasherizeFilter->filter($this->getModule($sprykDefinition));
        $controller = $dasherizeFilter->filter($this->getController($sprykDefinition));
        $action = $dasherizeFilter->filter($this->getAction($sprykDefinition));

        $parentNode = $xml->$module;
        if (!$parentNode) {
            $parentNode = current($xml->children());
        }

        $page = $parentNode->pages->addChild($module);
        $page->addChild('label', $this->getModule($sprykDefinition));
        $page->addChild('title', $this->getModule($sprykDefinition));
        $page->addChild('bundle', $module);
        $page->addChild('controller', $controller);
        $page->addChild('action', $action);

        $this->prettyPrintXml($xml, $sprykDefinition);

        $style->report(sprintf('Added navigation entry in <fg=green>%s</>', $this->getTargetPath($sprykDefinition)));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \Spryker\Spryk\Exception\XmlException
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @throws \Spryker\Spryk\Exception\XmlException
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getModule(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_MODULE)
            ->getValue();
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getController(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONTROLLER)
            ->getValue();
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getAction(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_ACTION)
            ->getValue();
    }

    /**
     * @return \Zend\Filter\FilterChain
     */
    protected function getDasherizeFilter(): FilterChain
    {
        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToDash())
            ->attach(new StringToLower());

        return $filterChain;
    }
}
