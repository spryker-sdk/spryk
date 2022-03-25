<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Persistence\Propel\Schema;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Persistence
 * @group Propel
 * @group Schema
 * @group AddZedPersistencePropelSchemaTest
 * Add your own group annotations below this line
 */
class AddZedPersistencePropelSchemaPropertyTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsPersistenceSchemaProperty(): void
    {
        $this->tester->havePersistenceFileWithTable(
            $this->tester->getSprykerModuleDirectory()
            . '/src/Spryker/Zed/FooBar/Persistence/Propel/Schema/spy_foo_bar.schema.xml',
            'spy_foo_bar',
        );

        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--name' => 'spy_foo_bar',
            '--propertyName' => 'testProperty',
            '--propertyType' => 'STRING',
            '--required' => 'true',
            '--defaultValue' => 'default value',
        ]);

        $expectedXml = '<database xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" name="zed" namespace="Orm\Zed\FooBar\Persistence" package="src.Orm.Zed.FooBar.Persistence" xsi:noNamespaceSchemaLocation="http://static.spryker.com/schema-01.xsd">
            <table class="FooBar" idMethod="native" name="spy_foo_bar">
                <column name="testProperty" type="STRING" required="true" defaultValue="default value"/>
            </table>
        </database>';

        $this->assertXmlStringEqualsXmlFile(
            $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Zed/FooBar/Persistence/Propel/Schema/spy_foo_bar.schema.xml',
            $expectedXml,
        );
    }
}
