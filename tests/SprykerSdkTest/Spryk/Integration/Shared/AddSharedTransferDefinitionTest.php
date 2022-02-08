<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Shared;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Shared
 * @group AddSharedTransferDefinitionTest
 * Add your own group annotations below this line
 */
class AddSharedTransferDefinitionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsSharedTransferDefinition(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--name' => 'FooBarItem',
        ]);

        $this->assertXmlStringEqualsXmlFile(
            $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Shared/FooBar/Transfer/foo_bar.transfer.xml',
            '<?xml version="1.0"?>
<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">
  <transfer name="FooBarItem"/>
</transfers>',
        );
    }

    /**
     * @return void
     */
    public function testAddsSharedTransferDefinitionOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--name' => 'FooBarItem',
            '--mode' => 'project',
        ]);

        $this->assertXmlStringEqualsXmlFile(
            $this->tester->getProjectModuleDirectory('FooBar', 'Shared') . 'Transfer/foo_bar.transfer.xml',
            '<?xml version="1.0"?>
<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">
  <transfer name="FooBarItem"/>
</transfers>',
        );
    }
}
