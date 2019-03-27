<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Model\Spryk\ConfigurationLoader;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Spryk
 * @group ConfigurationLoader
 * @group SprykConfigurationLoaderTest
 * Add your own group annotations below this line
 */
class SprykConfigurationLoaderTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testDoesNotReplaceEmptyValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertNull($sprykConfiguration['arguments']['emptyValue']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationDefaultWithRootConfigurationValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration['arguments']['replaceDefault']['default']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValueWithRootConfigurationValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration['arguments']['replaceValue']['value']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValueWithRootConfigurationValueInSubSpryk(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/foo-bar/', $sprykConfiguration['postSpryks'][0]['FooBarSpryk']['arguments']['replaceValue']['value']);
    }

    /**
     * @return void
     */
    public function testAddsRootArguments(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('foo/bar', $sprykConfiguration['arguments']['rootArgument']['value']);
    }

    /**
     * @return void
     */
    public function testAddsOnlyValueRootArguments(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertArrayNotHasKey('shouldNotBeMerged', $sprykConfiguration['arguments']);
    }
}
