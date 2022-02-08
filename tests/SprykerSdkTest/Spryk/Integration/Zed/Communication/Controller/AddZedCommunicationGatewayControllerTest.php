<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Communication\Controller;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group Controller
 * @group AddZedCommunicationGatewayControllerTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationGatewayControllerTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedGatewayControllerFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        $this->assertFileExists(
            $this->tester->getSprykerModuleDirectory()
            . 'src/Spryker/Zed/FooBar/Communication/Controller/GatewayController.php',
        );
    }

    /**
     * @return void
     */
    public function testAddsZedGatewayControllerFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--mode' => 'project',
        ]);

        $this->assertFileExists(
            $this->tester->getProjectModuleDirectory()
            . 'Communication/Controller/GatewayController.php',
        );
    }
}
