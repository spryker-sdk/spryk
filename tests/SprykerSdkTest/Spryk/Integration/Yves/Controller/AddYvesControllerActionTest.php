<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Controller;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Controller
 * @group AddYvesControllerActionTest
 * Add your own group annotations below this line
 */
class AddYvesControllerActionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesControllerAction(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::YVES_CONTROLLER,
            '--controllerMethod' => 'index',
        ]);

        $this->tester->assertClassHasMethod(ClassName::YVES_CONTROLLER, 'indexAction');
    }

    /**
     * @return void
     */
    public function testAddsYvesControllerActionOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::PROJECT_YVES_CONTROLLER,
            '--controllerMethod' => 'index',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_CONTROLLER, 'indexAction');
    }
}
