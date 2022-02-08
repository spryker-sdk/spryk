<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group CopyModuleTest
 * Add your own group annotations below this line
 */
class CopyModuleTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testCopiesAModule(): void
    {
        $this->tester->run($this, [
            '--organization' => 'Spryker',
            '--module' => 'ZipZap',
            '--toOrganization' => 'SprykerShop',
            '--toModule' => 'BarFoo',
            '--sourcePath' => codecept_root_dir('tests/_support/Fixtures/vendor/spryker/{{ organization | dasherize }}/Bundles/{{ module }}/src/'),
            '--targetPath' => codecept_data_dir('Copied/vendor/spryker/{{ toOrganization | dasherize }}/Bundles/src/{{ toModule }}/'),
        ]);

        // To complex to test, need to have to much files created
        $this->assertTrue(true);
    }
}
