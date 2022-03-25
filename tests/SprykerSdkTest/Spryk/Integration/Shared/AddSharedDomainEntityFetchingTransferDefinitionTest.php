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
 * @group AddSharedDomainEntityFetchingTransferDefinitionTest
 * Add your own group annotations below this line
 */
class AddSharedDomainEntityFetchingTransferDefinitionTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsSharedDomainEntityFetchingTransferDefinition(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--domainEntity' => 'FooBarModel',
        ]);

        $this->assertXmlStringEqualsXmlFile(
            $this->tester->getSprykerModuleDirectory() . 'src/Spryker/Shared/FooBar/Transfer/foo_bar.transfer.xml',
            '<?xml version="1.0"?>
<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">

  <transfer name="FooBarModelCriteria">
    <property name="fooBarModelConditions" type="FooBarModelConditions"/>
    <property name="sortCollection" singular="sort" type="Sort[]"/>
    <property name="pagination" type="Pagination"/>
  </transfer>

  <transfer name="FooBarModelConditions">
    <property name="fooBarModelIds" singular="fooBarModelId" type="int[]"/>
  </transfer>

  <transfer name="FooBarModelCollection">
    <property name="fooBarModels" singular="fooBarModel" type="FooBarModel[]"/>
    <property name="pagination" type="Pagination"/>
  </transfer>

  <transfer name="Sort">
    <property name="field" type="string"/>
    <property name="isAscending" type="bool"/>
  </transfer>

  <transfer name="Pagination">
    <property name="limit" type="int"/>
    <property name="offset" type="int"/>
    <property name="page" type="int"/>
    <property name="maxPerPage" type="int"/>
    <property name="nbResults" type="int"/>
    <property name="firstIndex" type="int"/>
    <property name="lastIndex" type="int"/>
    <property name="firstPage" type="int"/>
    <property name="lastPage" type="int"/>
    <property name="nextPage" type="int"/>
    <property name="previousPage" type="int"/>
  </transfer>

</transfers>',
        );
    }

    /**
     * @return void
     */
    public function testAddsSharedDomainEntityFetchingTransferDefinitionOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--domainEntity' => 'FooBarModel',
            '--mode' => 'project',
        ]);

        $this->assertXmlStringEqualsXmlFile(
            $this->tester->getProjectModuleDirectory('FooBar', 'Shared') . 'Transfer/foo_bar.transfer.xml',
            '<?xml version="1.0"?>
<transfers xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="spryker:transfer-01 http://static.spryker.com/transfer-01.xsd">

  <transfer name="FooBarModelCriteria">
    <property name="fooBarModelConditions" type="FooBarModelConditions"/>
    <property name="sortCollection" singular="sort" type="Sort[]"/>
    <property name="pagination" type="Pagination"/>
  </transfer>

  <transfer name="FooBarModelConditions">
    <property name="fooBarModelIds" singular="fooBarModelId" type="int[]"/>
  </transfer>

  <transfer name="FooBarModelCollection">
    <property name="fooBarModels" singular="fooBarModel" type="FooBarModel[]"/>
    <property name="pagination" type="Pagination"/>
  </transfer>

  <transfer name="Sort">
    <property name="field" type="string"/>
    <property name="isAscending" type="bool"/>
  </transfer>

  <transfer name="Pagination">
    <property name="limit" type="int"/>
    <property name="offset" type="int"/>
    <property name="page" type="int"/>
    <property name="maxPerPage" type="int"/>
    <property name="nbResults" type="int"/>
    <property name="firstIndex" type="int"/>
    <property name="lastIndex" type="int"/>
    <property name="firstPage" type="int"/>
    <property name="lastPage" type="int"/>
    <property name="nextPage" type="int"/>
    <property name="previousPage" type="int"/>
  </transfer>

</transfers>',
        );
    }
}
