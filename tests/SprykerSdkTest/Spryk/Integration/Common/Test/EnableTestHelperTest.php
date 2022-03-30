<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Common\Test;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedYmlInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Common
 * @group Test
 * @group EnableTestHelperTest
 * Add your own group annotations below this line
 */
class EnableTestHelperTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testEnablesTestHelper(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--layer' => 'Business',
            '--helperClassName' => 'SprykerTest\Zed\FooBar\Helper\ZipZapCrudHelper',
        ]);

        $codeceptionConfigYaml = $this->tester->getFileResolver()->resolve(
            $this->tester->getSprykerModuleDirectory() . 'tests/SprykerTest/Zed/FooBar/codeception.yml',
        );
        $this->assertInstanceOf(ResolvedYmlInterface::class, $codeceptionConfigYaml);

        $decodedYaml = $codeceptionConfigYaml->getDecodedYml();
        $enabledModules = $decodedYaml['suites']['Business']['modules']['enabled'] ?? null;

        $this->assertIsArray($enabledModules);
        $this->assertContains('SprykerTest\Zed\FooBar\Helper\ZipZapCrudHelper', $enabledModules);
    }
}
