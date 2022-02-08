<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use SimpleXMLElement;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface;
use SprykerSdk\Spryk\Model\Spryk\Filter\CamelCaseToUnderscoreFilter;

class TransferModule extends Module
{
 /**
  * @param string $organization
  * @param string $module
  * @param string $content
  *
  * @return string
  */
    public function haveTransferSchema(string $organization, string $module, string $content): string
    {
        $underScoreFilter = new CamelCaseToUnderscoreFilter();

        $filePath = $this->getSprykHelper()->getVirtualDirectory() . sprintf('/vendor/spryker/spryker/Bundles/%s/src/%s/Shared/%s/Transfer/%s.transfer.xml', $module, $organization, $module, $underScoreFilter->filter($module));
        $directory = dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($filePath, $content);

        return $filePath;
    }

    /**
     * @return \SprykerSdkTest\Module\SprykHelper
     */
    protected function getSprykHelper(): SprykHelper
    {
        /** @var \SprykerSdkTest\Module\SprykHelper $sprykHelper */
        $sprykHelper = $this->getModule(SprykHelper::class);

        return $sprykHelper;
    }

    /**
     * @param string $pathToTransferFile
     * @param string $transferName
     *
     * @return void
     */
    public function haveTransferSchemaFileWithTransferAndExistingProperty(string $pathToTransferFile, string $transferName): void
    {
        $transferSchema = sprintf('<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">
  <transfer name="FooBar">
    <property name="something" type="string" />
  </transfer>

  <transfer name="%s">
    <property name="testProperty" type="string" />
  </transfer>

</transfers>', $transferName);

        $directory = dirname($pathToTransferFile);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($pathToTransferFile, $transferSchema);
    }

    /**
     * @param string $pathToTransferFile
     * @param string $transferName
     *
     * @return void
     */
    public function haveTransferSchemaFileWithTransfer(string $pathToTransferFile, string $transferName): void
    {
        $transferSchema = sprintf('<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">
  <transfer name="FooBar">
    <property name="something" type="string" />
  </transfer>

  <transfer name="%s">
  </transfer>

</transfers>', $transferName);

        $directory = dirname($pathToTransferFile);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        file_put_contents($pathToTransferFile, $transferSchema);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface $resolvedXml
     * @param string $transferName
     * @param string $propertyName
     * @param string $propertyType
     * @param string|null $singular
     *
     * @return void
     */
    public function assertResolvedXmlHasProperty(
        ResolvedXmlInterface $resolvedXml,
        string $transferName,
        string $propertyName,
        string $propertyType,
        ?string $singular = null
    ): void {
        $simpleXMLElement = $resolvedXml->getSimpleXmlElement();
        $this->assertInstanceOf(SimpleXMLElement::class, $simpleXMLElement);

        $property = $simpleXMLElement->xpath(sprintf('//transfer[@name="%s"]/property[@name="%s"]', $transferName, $propertyName))[0];
        $this->assertInstanceOf(SimpleXMLElement::class, $property);
        $propertyString = $property->asXML();
        $expectedPropertyString = sprintf('<property name="%s" type="%s"%s/>', $propertyName, $propertyType, $singular ? sprintf(' singular="%s"', $singular) : '');

        $this->assertSame($expectedPropertyString, $propertyString);
    }
}
