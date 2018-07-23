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
    const ARGUMENT_TARGET_PATH = 'targetPath';
    const ARGUMENT_MODULE = 'module';
    const ARGUMENT_CONTROLLER = 'controller';
    const ARGUMENT_ACTION = 'method';

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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykerDefinition): bool
    {
        return true;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykerDefinition, SprykStyleInterface $style): void
    {
        $dasherizeFilter = $this->getDasherizeFilter();

        $module = $dasherizeFilter->filter($this->getModule($sprykerDefinition));
        $controller = $dasherizeFilter->filter($this->getController($sprykerDefinition));
        $action = $dasherizeFilter->filter($this->getAction($sprykerDefinition));

        $xml = $this->getXml($sprykerDefinition);

        $page = $xml->$module->pages->addChild($module);
        $page->addChild('label', $this->getModule($sprykerDefinition));
        $page->addChild('title', $this->getModule($sprykerDefinition));
        $page->addChild('bundle', $module);
        $page->addChild('controller', $controller);
        $page->addChild('action', $action);

        $this->prettyPrintXml($xml, $sprykerDefinition);

        $style->report(sprintf('Added navigation entry in <fg=green>%s</>', $this->getTargetPath($sprykerDefinition)));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @throws \Spryker\Spryk\Exception\XmlException
     *
     * @return \SimpleXMLElement
     */
    protected function getXml(SprykDefinitionInterface $sprykerDefinition): SimpleXMLElement
    {
        $targetPath = $this->getTargetPath($sprykerDefinition);
        $xml = simplexml_load_file($targetPath);

        if (!($xml instanceof SimpleXMLElement)) {
            throw new XmlException('Could not load xml file!');
        }

        return $xml;
    }

    /**
     * @param \SimpleXMLElement $xml
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \Spryker\Spryk\Exception\XmlException
     *
     * @return void
     */
    protected function prettyPrintXml(SimpleXMLElement $xml, SprykDefinitionInterface $sprykDefinition): void
    {
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $xmlString = $xml->asXML();
        if (!is_string($xmlString)) {
            throw new XmlException('Could not get xml as string!');
        }
        $dom->loadXML($xmlString);
        $dom->save($this->getTargetPath($sprykDefinition));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykerDefinition): string
    {
        return $this->rootDirectory . $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getModule(SprykDefinitionInterface $sprykerDefinition): string
    {
        return $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_MODULE)
            ->getValue();
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getController(SprykDefinitionInterface $sprykerDefinition): string
    {
        return $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONTROLLER)
            ->getValue();
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getAction(SprykDefinitionInterface $sprykerDefinition): string
    {
        return $sprykerDefinition
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
