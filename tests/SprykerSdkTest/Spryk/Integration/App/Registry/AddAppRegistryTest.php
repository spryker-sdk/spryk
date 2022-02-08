<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\App\Registry;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group App
 * @group Registry
 * @group AddAppRegistryTest
 * Add your own group annotations below this line
 */
class AddAppRegistryTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsAppRegistryCode(): void
    {
        $this->markTestSkipped('Not tested');

        $this->tester->run($this, [
            '--module' => 'FooBarConfig',
        ]);

        $this->assertFileExists(codecept_data_dir('/config/app/api/asyncapi/asyncapi.yml'));
    }
}
