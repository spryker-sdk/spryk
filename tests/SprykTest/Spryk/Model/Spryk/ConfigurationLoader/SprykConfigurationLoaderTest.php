<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Model\Spryk\ConfigurationLoader;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerTest
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
     * @var \SprykTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testDoesNotReplaceEmptyValue(): void
    {
        $sprykConfiguration = $this->tester->getMergedConfiguration(__DIR__);

        $this->assertSame(null, $sprykConfiguration['arguments']['emptyValue']);
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
}
