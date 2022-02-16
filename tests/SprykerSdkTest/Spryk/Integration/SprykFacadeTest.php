<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;
use ReflectionClass;
use SprykerSdk\Spryk\SprykFacade;
use SprykerSdk\Spryk\SprykFactory;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group SprykFacadeTest
 * Add your own group annotations below this line
 */
class SprykFacadeTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * This test ensures that external packages can instantiate the facade and get all services auto-wired.
     *
     * @return void
     */
    public function testCreateSprykFacadeWillBootTheApplication(): void
    {
        $sprykFacade = new SprykFacade();
        $reflection = new ReflectionClass($sprykFacade);
        $factoryProperty = $reflection->getProperty('factory');
        $factoryProperty->setAccessible(true);

        $this->assertInstanceOf(SprykFactory::class, $factoryProperty->getValue($sprykFacade));
    }
}
