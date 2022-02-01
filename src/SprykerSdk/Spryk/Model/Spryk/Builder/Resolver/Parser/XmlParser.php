<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Parser;

use SimpleXMLElement;
use SprykerSdk\Spryk\Exception\XmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXml;

class XmlParser implements ParserInterface
{
    /**
     * @param string $type
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface
     */
    public function parse(string $type): ResolvedInterface
    {
        if (is_file($type)) {
            return $this->fromFilePath($type);
        }

        return $this->fromFileContent($type);
    }

    /**
     * @param string $filePath
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXml
     */
    protected function fromFilePath(string $filePath): ResolvedXml
    {
        $resolved = new ResolvedXml();
        $resolved->setFilePath($filePath);

        $fileContents = file_get_contents($filePath);

        if (!$fileContents) {
            return $resolved;
        }

        $resolved = $this->fromFileContent($fileContents);
        $resolved->setFilePath($filePath);

        return $resolved;
    }

    /**
     * @param string $fileContents
     *
     * @throws \SprykerSdk\Spryk\Exception\XmlException
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXml
     */
    protected function fromFileContent(string $fileContents): ResolvedXml
    {
        $resolved = new ResolvedXml();

        $resolved->setOriginalContent($fileContents);
        $resolved->setContent($fileContents);

        $simpleXMLElement = simplexml_load_string($fileContents);

        if (!($simpleXMLElement instanceof SimpleXMLElement)) {
            throw new XmlException('Could not load xml file!');
        }
        $resolved->setSimpleXmlElement($simpleXMLElement);

        return $resolved;
    }
}
