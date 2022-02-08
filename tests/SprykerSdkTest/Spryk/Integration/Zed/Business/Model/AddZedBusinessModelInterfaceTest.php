<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Business\Model;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Business
 * @group Model
 * @group AddZedBusinessModelInterfaceTest
 * Add your own group annotations below this line
 */
class AddZedBusinessModelInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedBusinessModelInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Foo',
            '--className' => 'Bar',
        ]);

        $this->assertFileExists($this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Business/Foo/BarInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsZedBusinessModelInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--subDirectory' => 'Foo',
            '--className' => 'Bar',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory() . 'Business/Foo/BarInterface.php');
    }
}
