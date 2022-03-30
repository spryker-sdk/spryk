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
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_EXTENDER', 'PLUGINS_ZIP_ZAP_EXTENDER', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_PRE_CREATE', 'PLUGINS_ZIP_ZAP_PRE_CREATE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_POST_CREATE', 'PLUGINS_ZIP_ZAP_POST_CREATE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_PRE_UPDATE', 'PLUGINS_ZIP_ZAP_PRE_UPDATE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_POST_UPDATE', 'PLUGINS_ZIP_ZAP_POST_UPDATE', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_UPDATE_VALIDATOR', 'PLUGINS_ZIP_ZAP_UPDATE_VALIDATOR', 'public');
        $this->tester->assertClassHasConstant(ClassName::ZED_DEPENDENCY_PROVIDER, 'PLUGINS_ZIP_ZAP_CREATE_VALIDATOR', 'PLUGINS_ZIP_ZAP_CREATE_VALIDATOR', 'public');

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

        // BusinessFactory create/get methods
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'createZipZapIdentifierBuilder');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'createZipZapCreateValidator');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapCreateValidatorRules');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'createZipZapUpdateValidator');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapUpdateValidatorRules');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapExtenderPlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapPreCreatePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapPostCreatePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapPreUpdatePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapPostUpdatePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapUpdateValidatorRulePlugins');
        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapCreateValidatorRulePlugins');

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/IdentifierBuilder/ZipZapIdentifierBuilder.php',
        );
        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/IdentifierBuilder/ZipZapIdentifierBuilderInterface.php',
        );
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

        # Updater Model
        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Saver/ZipZapUpdater.php',
        );
        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/ZipZap/Saver/ZipZapUpdaterInterface.php',
        );
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\ZipZap\Saver\ZipZapUpdater', 'updateZipZapCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\ZipZap\Saver\ZipZapUpdaterInterface', 'updateZipZapCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createZipZapUpdater');

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

        // Test helper
        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/_support/Helper/ZipZapCrudHelper.php',
        );
    }

    /**
     * @return void
     */
    public function testPluginsExist(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBarExtension/Dependency/ZipZap/Expander/ZipZapExpanderPluginInterface.php',
        );

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBarExtension/Dependency/ZipZap/Saver/ZipZapPreSavePluginInterface.php',
        );

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBarExtension/Dependency/ZipZap/Saver/ZipZapPostSavePluginInterface.php',
        );

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBarExtension/Dependency/ZipZap/Validator/ZipZapValidatorRulePluginInterface.php',
        );
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

    /**
     * @return void
     */
    public function testRepositoryContainsCrudMethods(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--domainEntity' => 'FooBar',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_REPOSITORY, 'getFooBarCollection');
        $this->tester->assertClassHasMethod(ClassName::ZED_REPOSITORY, 'applyFooBarFilters');
        $this->tester->assertClassHasMethod(ClassName::ZED_REPOSITORY, 'hasFooBar');
        $this->tester->assertClassHasMethod(ClassName::ZED_REPOSITORY, 'getFooBarDeleteCollection');
        $this->tester->assertClassHasMethod(ClassName::ZED_REPOSITORY, 'applyFooBarDeleteFilters');
    }

    /**
     * @return void
     */
    public function testCreateValidatorExists(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/Validator/ZipZap/ZipZapCreateValidator.php',
        );

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapCreateValidator', 'validate');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapCreateValidator', 'validateCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapCreateValidator', 'validateCollectionTransactional');
    }

    /**
     * @return void
     */
    public function testUpdateValidatorExists(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/Validator/ZipZap/ZipZapUpdateValidator.php',
        );

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapUpdateValidator', 'validate');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapUpdateValidator', 'validateCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapUpdateValidator', 'validateCollectionTransactional');
    }

    /**
     * @return void
     */
    public function testValidatorExists(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/Validator/ZipZap/ZipZapValidator.php',
        );

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidator', 'validate');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidator', 'validateCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidator', 'validateCollectionTransactional');
    }

    /**
     * @return void
     */
    public function testPersistenceFactoryContainsMethods(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_PERSISTENCE_FACTORY, 'createZipZapQuery');
    }
}
