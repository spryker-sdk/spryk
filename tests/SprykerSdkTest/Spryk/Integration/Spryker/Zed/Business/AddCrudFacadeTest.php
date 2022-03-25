<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Spryker\Zed\Business;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedXmlInterface;
use SprykerSdkTest\Module\ClassName;
use SprykerSdkTest\SprykIntegrationTester;

/**
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Spryker
 * @group Zed
 * @group Business
 * @group AddCrudFacadeTest
 */
class AddCrudFacadeTest extends Unit
{
    protected SprykIntegrationTester $tester;

    /**
     * @return void
     */
    public function testFilesExist(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        // DependencyProvider constants
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_CREATE_PRE_SAVE', 'PLUGINS_ZIP_ZAP_CREATE_PRE_SAVE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_CREATE_POST_SAVE', 'PLUGINS_ZIP_ZAP_CREATE_POST_SAVE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_UPDATE_PRE_SAVE', 'PLUGINS_ZIP_ZAP_UPDATE_PRE_SAVE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_UPDATE_POST_SAVE', 'PLUGINS_ZIP_ZAP_UPDATE_POST_SAVE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_EXPANDER', 'PLUGINS_ZIP_ZAP_EXPANDER', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_UPDATE_VALIDATOR_RULE', 'PLUGINS_ZIP_ZAP_UPDATE_VALIDATOR_RULE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_CREATE_VALIDATOR_RULE', 'PLUGINS_ZIP_ZAP_CREATE_VALIDATOR_RULE', 'public');

        // DependencyProvider provide method
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'provideBusinessLayerDependencies');

        // DependencyProvider add/get methods
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapCreatePreSavePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapCreatePreSavePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapCreatePostSavePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapCreatePostSavePlugins');

        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapUpdatePreSavePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapUpdatePreSavePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapUpdatePostSavePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapUpdatePostSavePlugins');

        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapCreateValidatorRulePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapCreateValidatorRulePlugins');

        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapUpdateValidatorRulePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapUpdateValidatorRulePlugins');

        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'addZipZapExpanderPlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_DEPENDENCY_PROVIDER, 'getZipZapExpanderPlugins');

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Saver/ZipZapCreator.php',
        );
        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Saver/ZipZapCreatorInterface.php',
        );

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Deleter/ZipZapDeleter.php',
        );

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Reader/ZipZapReader.php',
        );
        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Reader/ZipZapReaderInterface.php',
        );

        // Transfers
        $transferXml = $this->tester->getFileResolver()->resolve(
            $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Shared/FooBar/Transfer/foo_bar.transfer.xml',
        );
        $this->assertInstanceOf(ResolvedXmlInterface::class, $transferXml);

        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'ZipZapCriteria');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'ZipZapConditions');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'ZipZapCollection');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'Sort');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'Pagination');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'ZipZapCollectionRequest');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'ZipZapCollectionResponse');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'ZipZapCollectionDeleteCriteria');
        $this->tester->assertResolvedXmlHasTransfer($transferXml, 'Error');
    }

    /**
     * @return void
     */
    public function testFacadeContainsCrudMethods(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--domainEntity' => 'FooBar',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE, 'getFooBarCollection');
        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE, 'createFooBarCollection');
        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE, 'updateFooBarCollection');
        $this->tester->assertClassHasMethod(ClassName::ZED_FACADE, 'deleteFooBarCollection');
    }
}
