<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group AddSharedRestAttributesTransferTest
 * Add your own group annotations below this line
 */
class AddSharedRestAttributesTransferTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsSharedTransferSchemaFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--name' => 'RestFooBarrAttributes',
        ]);

        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Shared/FooBar/Transfer/foo_bar.transfer.xml');
    }

    /**
     * @return void
     */
    public function testAddsSharedTransferSchemaFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--name' => 'RestFooBarrAttributes',
            '--mode' => 'project',
        ]);

        $this->tester->assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Shared')
            . 'Transfer/foo_bar.transfer.xml'
        );
    }
}
