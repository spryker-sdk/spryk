<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Model\Spryk\ConfigurationLoader;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\SprykConfig;

/**
 * Auto-generated group annotations
 *
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
    protected function _before(): void
    {
        $this->markTestSkipped('Not needed anymore when refactoring of Spryks is done');
    }

    /**
     * @return void
     */
    public function testDoesNotReplaceEmptyValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertNull($sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['emptyValue']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationDefaultWithRootConfigurationValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['replaceDefault'][SprykConfig::NAME_ARGUMENT_KEY_DEFAULT]);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValueWithRootConfigurationValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['replaceValue'][SprykConfig::NAME_ARGUMENT_KEY_VALUE]);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValueWithRootConfigurationValueInSubSpryk(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('vendor/spryker/spryker/Bundles/%module%/src/foo-bar/', $sprykConfiguration['postSpryks'][0]['FooBarSpryk'][SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['replaceValue'][SprykConfig::NAME_ARGUMENT_KEY_VALUE]);
    }

    /**
     * @return void
     */
    public function testAddsRootArguments(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame('foo/bar', $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]['rootArgument'][SprykConfig::NAME_ARGUMENT_KEY_VALUE]);
    }

    /**
     * @return void
     */
    public function testAddsOnlyValueRootArguments(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertArrayNotHasKey('shouldNotBeMerged', $sprykConfiguration[SprykConfig::SPRYK_DEFINITION_KEY_ARGUMENTS]);
    }
}
