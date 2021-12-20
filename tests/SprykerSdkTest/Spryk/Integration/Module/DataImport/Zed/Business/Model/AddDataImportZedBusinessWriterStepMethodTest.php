<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Module\DataImport\Zed\Business\Model;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Module
 * @group DataImport
 * @group Zed
 * @group Business
 * @group Model
 * @group AddDataImportZedBusinessWriterStepMethodTest
 * Add your own group annotations below this line
 */
class AddDataImportZedBusinessWriterStepMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsDataImportZedBusinessWriterStepMethod(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBarItemWriter',
            '--subDirectory' => 'Writer',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
        ]);

        $this->tester->assertClassHasMethod(
            'Spryker\Zed\FooBar\Business\Writer\FooBarItemWriter',
            'addSomething',
        );
    }

    /**
     * @return void
     */
    public function testAddsDataImportZedBusinessWriterStepMethodOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--className' => 'FooBarItemWriter',
            '--subDirectory' => 'Writer',
            '--modelMethod' => 'addSomething',
            '--input' => 'string $foo',
            '--output' => 'bool',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(
            'Pyz\Zed\FooBar\Business\Writer\FooBarItemWriter',
            'addSomething',
        );
    }
}
