<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Schema;

use SimpleXMLElement;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Filter\CamelCaseFilter;
use SprykerSdk\Spryk\SprykConfig;

class SchemaSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    public const ARGUMENT_TABLE_NAME = 'tableName';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Filter\CamelCaseFilter
     */
    protected CamelCaseFilter $filter;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\Filter\CamelCaseFilter $filter
     */
    public function __construct(SprykConfig $config, FileResolverInterface $fileResolver, CamelCaseFilter $filter)
    {
        parent::__construct($config, $fileResolver);

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
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());
        $simpleXmlElement = $resolved->getSimpleXmlElement();

        $tableName = $this->getTableName();

        if ($this->isTableDefinedInSchema($simpleXmlElement, $tableName)) {
            return;
        }

        $tableNodeXmlElement = $simpleXmlElement->addChild('table');
        $tableNodeXmlElement->addAttribute('name', $tableName);
        $tableNodeXmlElement->addAttribute('idMethod', 'native');
        $tableNodeXmlElement->addAttribute('class', $this->filter->filter($tableName));

        $resolved->setSimpleXmlElement($simpleXmlElement);

        $this->log(sprintf('Added table to <fg=green>%s</>', $this->getTargetPath()));
    }

    /**
     * @return string
     */
    protected function getTableName(): string
    {
        return $this->getStringArgument(static::ARGUMENT_TABLE_NAME);
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
