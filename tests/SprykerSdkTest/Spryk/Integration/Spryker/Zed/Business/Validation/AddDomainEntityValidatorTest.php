<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Spryker\Zed\Business\Validation;

use Codeception\Test\Unit;
use SprykerSdkTest\SprykIntegrationTester;

/**
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Spryker
 * @group Zed
 * @group Business
 * @group Validation
 * @group AddDomainEntityValidatorTest
 */
class AddDomainEntityValidatorTest extends Unit
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

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/Validator/ZipZap/ZipZapValidator.php',
        );

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Business/Validator/ZipZap/ZipZapValidatorInterface.php',
        );

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidator', 'validate');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidator', 'validateCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidator', 'validateCollectionTransactional');

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidatorInterface', 'validate');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidatorInterface', 'validateCollection');
        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\Validator\ZipZap\ZipZapValidatorInterface', 'validateCollectionTransactional');

        $this->tester->assertClassHasMethod('Spryker\Zed\FooBar\Business\FooBarBusinessFactory', 'createZipZapValidator');
    }
}
