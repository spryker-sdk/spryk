<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Processor
 * @group AddGlueProcessorModelInterfaceMethodTest
 * Add your own group annotations below this line
 */
class AddGlueProcessorModelInterfaceMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @dataProvider getProcessorModelInterfaceMethodData
     *
     * @param array $params
     * @param string $className
     * @param string $methodName
     *
     * @return void
     */
    public function testAddsGlueFactoryMethod(
        array $params,
        string $className,
        string $methodName
    ): void {
        $this->tester->run($this, $params);
        $this->tester->assertClassHasMethod($className, $methodName);
    }

    /**
     * @return array
     */
    public function getProcessorModelInterfaceMethodData(): array
    {
        return [
            [
                [
                    '--module' => 'FooBar',
                    '--className' => 'FooBarProcessor',
                    '--method' => 'bazQux',
                    '--input' => 'string $something',
                    '--output' => 'bool',
                ],
                'Spryker\Glue\FooBar\Processor\FooBarProcessorInterface',
                'bazQux',
            ],
            [
                [
                    '--module' => 'FooBar',
                    '--className' => 'FooBarProcessor',
                    '--method' => 'bazQux',
                    '--input' => 'string $something',
                    '--output' => 'bool',
                    '--mode' => 'project',
                ],
                'Pyz\Glue\FooBar\Processor\FooBarProcessorInterface',
                'bazQux',
            ],
        ];
    }
}
