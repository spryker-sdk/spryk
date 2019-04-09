<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\GlueBackOffice;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group GlueBackOffice
 * @group AddGlueBackOfficeResourceTest
 * Add your own group annotations below this line
 */
class AddGlueBackOfficeResourceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueBackOfficeResource(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBarBackOffice',
        ]);

        $this->assertFileExists($this->tester->getModuleDirectory('FooBarBackOffice') . 'src/Spryker/Glue/FooBarBackOffice/FooBarBackOfficeResource.php');
    }

    /**
     * @return void
     */
    public function testAddsGlueBackOfficeResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBarBackOffice',
            '--mode' => 'project',
        ]);

        $this->assertFileExists($this->tester->getProjectModuleDirectory('FooBarBackOffice', 'Glue') . 'FooBarBackOfficeResource.php');
    }
}
