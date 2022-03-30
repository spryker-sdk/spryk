<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Test\Helper;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Test
 * @group Helper
 * @group AddDomainEntityTestHelperTest
 * Add your own group annotations below this line
 */
class AddDomainEntityTestHelperTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedTestHelper(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--domainEntity' => 'ZipZap',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/_support/Helper/ZipZapCrudHelper.php');
    }
}
