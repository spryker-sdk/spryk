<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Plugin\GlueApplication;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Plugin
 * @group GlueApplication
 * @group AddGlueResourceRouteTest
 * Add your own group annotations below this line
 */
class AddGlueResourceRouteTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueResource(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--resourceRouteMethod' => 'get',
            '--mode' => 'core',
        ]);

        $this->tester->assertRouteAdded(
            'Spryker\Glue\FooBar\Plugin\GlueApplication\FooBarsResourceRoutePlugin',
            'addGet',
        );
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceRouteMethod' => 'get',
            '--resourceType' => 'foo-bars',
            '--mode' => 'project',
        ]);

        $this->tester->assertRouteAdded(
            'Pyz\Glue\FooBar\Plugin\GlueApplication\FooBarsResourceRoutePlugin',
            'addGet',
        );
    }
}
