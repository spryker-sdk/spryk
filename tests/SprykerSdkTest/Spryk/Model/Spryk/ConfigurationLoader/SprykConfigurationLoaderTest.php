<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
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

        static::assertNull($sprykConfiguration['arguments']['emptyValue']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationDefaultWithRootConfigurationValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        static::assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration['arguments']['replaceDefault']['default']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValueWithRootConfigurationValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        static::assertSame('vendor/spryker/spryker/Bundles/%module%/src/', $sprykConfiguration['arguments']['replaceValue']['value']);
    }

    /**
     * @return void
     */
    public function testPrependsSprykConfigurationValueWithRootConfigurationValueInSubSpryk(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        static::assertSame('vendor/spryker/spryker/Bundles/%module%/src/foo-bar/', $sprykConfiguration['postSpryks'][0]['FooBarSpryk']['arguments']['replaceValue']['value']);
    }

    /**
     * @return void
     */
    public function testAddsRootArguments(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        static::assertSame('foo/bar', $sprykConfiguration['arguments']['rootArgument']['value']);
    }

    /**
     * @return void
     */
    public function testAddsOnlyValueRootArguments(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        static::assertArrayNotHasKey('shouldNotBeMerged', $sprykConfiguration['arguments']);
    }
}
