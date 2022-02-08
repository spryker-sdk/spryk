<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Model\Spryk\Builder\Transfer;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Transfer\TransferPropertySpryk;

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
        $transferFilePath = $this->tester->haveTransferSchema(
            'Spryker',
            'FooBar',
            file_get_contents(codecept_data_dir('/../_support/Fixtures/Transfer/foo_bar.transfer.xml')),
        );
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
            'targetPath' => 'src/Spryker/Shared/FooBar/Transfer/foo_bar.transfer.xml',
        ]);

        // Act
        $fileResolver = $this->tester->getFileResolver();
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder $transferPropertySpryk */
        $transferPropertySpryk = $this->tester->getClass(TransferPropertySpryk::class);
        $transferPropertySpryk->runSpryk($sprykDefinition);
        $this->tester->persistResolvedFiles();

        // Assert
        $resolved = $fileResolver->resolve($transferFilePath);
        $this->assertInstanceOf(ResolvedXmlInterface::class, $resolved);

        $this->tester->assertResolvedXmlHasProperty($resolved, $transferName, $propertyAName, $propertyType);
        $this->tester->assertResolvedXmlHasProperty($resolved, $transferName, $propertyBName, $propertyType, 'withSingular');
    }
}
