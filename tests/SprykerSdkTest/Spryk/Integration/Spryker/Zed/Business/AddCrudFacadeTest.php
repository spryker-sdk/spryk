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
}
