<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\App\Common\Api\AsyncApi;

use Codeception\Test\Unit;
use SprykerSdkTest\SprykIntegrationTester;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group App
 * @group Common
 * @group Api
 * @group AsyncApi
 * @group AddAsyncApiTest
 * Add your own group annotations below this line
 */
class AddAsyncApiTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected SprykIntegrationTester $tester;

    /**
     * @return void
     */
    public function testAddsAsyncApiFile(): void
    {
        $this->tester->run($this, [
            '--title' => 'FooBar',
            '--targetPath' => 'config/app/api/asyncapi/',
            '--targetFilename' => 'asyncapi.yml',
        ]);

        $this->assertFileExists($this->tester->getVirtualDirectory() . '/config/app/api/asyncapi/asyncapi.yml');
    }
}
