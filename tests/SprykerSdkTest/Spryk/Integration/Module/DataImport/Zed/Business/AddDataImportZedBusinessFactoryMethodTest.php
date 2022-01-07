<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Module\DataImport\Zed\Business;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Module
 * @group DataImport
 * @group Zed
 * @group Business
 * @group AddDataImportZedBusinessFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddDataImportZedBusinessFactoryMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDataImportZedBusinessFactoryMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--entity' => 'FooBarItem',
        ]);

        $this->tester->assertClassHasMethod(
            ClassName::DATA_IMPORT_BUSINESS_FACTORY,
            'getFooBarItemDataImporter',
        );
    }

    /**
     * @return void
     */
    public function testAddsDataImportZedBusinessFactoryMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--entity' => 'FooBarItem',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(
            ClassName::PROJECT_DATA_IMPORT_BUSINESS_FACTORY,
            'getFooBarItemDataImporter',
        );
    }
}
