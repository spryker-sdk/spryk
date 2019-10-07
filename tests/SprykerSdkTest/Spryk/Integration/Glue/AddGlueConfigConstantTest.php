<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group AddGlueConfigConstantTest
 * Add your own group annotations below this line
 */
class AddGlueConfigConstantTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueConfigConstant(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'FooBar',
            '--name' => 'FOO_BAR_CONSTANT',
            '--value' => 'FOO_BAR_CONSTANT',
            '--visibility' => 'public',
            '--mode' => 'core',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::GLUE_CONFIG,
            'FOO_BAR_CONSTANT',
            'FOO_BAR_CONSTANT',
            'public'
        );
    }

    /**
     * @return void
     */
    public function testAddsGlueConfigConstantOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'FooBar',
            '--name' => 'FOO_BAR_CONSTANT',
            '--value' => 'FOO_BAR_CONSTANT',
            '--visibility' => 'public',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasConstant(
            ClassName::PROJECT_GLUE_CONFIG,
            'FOO_BAR_CONSTANT',
            'FOO_BAR_CONSTANT',
            'public'
        );
    }
}
