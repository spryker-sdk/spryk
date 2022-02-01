<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Model\Spryk\Builder\Transfer;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Transfer\TransferPropertySpryk;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

/**
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Transfer
 * @group TransferPropertySprykTest
 */
class TransferPropertySprykTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddMultiplePropertiesAddsMultipleProperties(): void
    {
        // Arrange
        $targetXmlPath = '/../../_support/Fixtures/Transfer/foo_bar.transfer.xml';
        $transferName = 'FooBar';
        $propertyAName = 'propertyA';
        $propertyBName = 'propertyB';
        $propertyType = 'string';
        $sprykDefinition = $this->tester->getSprykDefinition([
            'organization' => 'Spryker',
            'module' => 'FooBar',
            'name' => $transferName,
            'propertyName' => [
                sprintf('%s:%s', $propertyAName, $propertyType),
                sprintf('%s:%s:withSingular', $propertyBName, $propertyType),
            ],
            'propertyType' => 'empty',
            'targetPath' => $targetXmlPath,
        ]);

        // Act
        $fileResolver = $this->tester->getFileResolver();
        $transferPropertySpryk = new TransferPropertySpryk(codecept_data_dir('config'), $fileResolver);
        $transferPropertySpryk->build($sprykDefinition, $this->getSprykStyleMock());

        // Assert
        $resolved = $fileResolver->resolve(codecept_data_dir('config') . $targetXmlPath);
        $this->assertInstanceOf(ResolvedXmlInterface::class, $resolved);

        $this->tester->assertResolvedXmlHasProperty($resolved, $transferName, $propertyAName, $propertyType);
        $this->tester->assertResolvedXmlHasProperty($resolved, $transferName, $propertyBName, $propertyType, 'withSingular');
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected function getSprykStyleMock(): SprykStyleInterface
    {
        $mockBuilder = $this->getMockBuilder(SprykStyleInterface::class);

        return $mockBuilder->getMock();
    }
}
