<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Dependency
 * @group Client
 * @group AddGlueDependencyClientToDependencyProviderTest
 * Add your own group annotations below this line
 */
class AddGlueDependencyClientToDependencyProviderTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueDependencyClientToDependencyProvider(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $expectedBody = '$container->set(static::CLIENT_ZIP_ZAP, function (\Spryker\Glue\Kernel\Container $container) {
    return new \Spryker\Glue\FooBar\Dependency\Client\FooBarToZipZapClientBridge($container->getLocator()->zipZap()->client());
});
return $container;';
        $this->tester->assertMethodBody(ClassName::GLUE_DEPENDENCY_PROVIDER, 'addZipZapClient', $expectedBody);
    }

    /**
     * @return void
     */
    public function testAddsGlueDependencyClientToDependencyProviderOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $expectedBody = '$container->set(static::CLIENT_ZIP_ZAP, function (\Spryker\Glue\Kernel\Container $container) {
    return new \Pyz\Glue\FooBar\Dependency\Client\FooBarToZipZapClientBridge($container->getLocator()->zipZap()->client());
});
return $container;';
        $this->tester->assertMethodBody(ClassName::PROJECT_GLUE_DEPENDENCY_PROVIDER, 'addZipZapClient', $expectedBody);
    }
}
