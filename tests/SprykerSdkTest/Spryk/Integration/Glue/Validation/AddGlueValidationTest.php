<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Validation;

use Codeception\Test\Unit;

class AddGlueValidationTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueConfig(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--mode' => 'core',
        ]);

        $this->tester->assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Glue/FooBar/Validation/foo-bars.validation.yaml');
    }

    /**
     * @return void
     */
    public function testAddsGlueConfigOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--mode' => 'project',
        ]);

        $this->tester->assertFileExists($this->tester->getProjectModuleDirectory('FooBar', 'Glue') . 'Validation/foo-bars.validation.yaml');
    }
}
