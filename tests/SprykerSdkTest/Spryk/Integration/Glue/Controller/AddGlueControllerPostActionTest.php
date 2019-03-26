<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Controller;

use Codeception\Test\Unit;
use Roave\BetterReflection\BetterReflection;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Controller
 * @group AddGlueControllerPostActionTest
 * Add your own group annotations below this line
 */
class AddGlueControllerPostActionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueControllerAction(): void {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Bar',
            '--resourceType' => 'foo-bars',
        ]);

        $this->tester->assertClassHasMethod(
            'Spryker\Glue\FooBar\Controller\BarController',
            'postAction'
        );
    }

    /**
     * @return void
     */
    public function testAddsGlueControllerOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Bar',
            '--resourceType' => 'foo-bars',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(
            '\Pyz\Glue\FooBar\Controller\BarController',
            'postAction'
        );
    }
}
