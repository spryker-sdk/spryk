<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\RouteProvider;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group RouteProvider
 * @group AddYvesRouteProviderActionTest
 * Add your own group annotations below this line
 */
class AddYvesRouteProviderActionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesRouteProviderAction(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::YVES_CONTROLLER,
            '--controllerMethod' => 'index',
        ]);

        $this->tester->assertClassHasMethod(ClassName::YVES_ROUTE_PROVIDER, 'addIndexRoute');
    }

    /**
     * @return void
     */
    public function testAddsYvesRouteProviderActionOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::PROJECT_YVES_CONTROLLER,
            '--controllerMethod' => 'index',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_ROUTE_PROVIDER, 'addIndexRoute');
    }
}
