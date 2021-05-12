<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Processor;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Processor
 * @group AddGlueProcessorModelMethodTest
 * Add your own group annotations below this line
 */
class AddGlueProcessorModelMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @dataProvider getProcessorModelMethodData
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
        $this->tester->assertClassHasMethod($className . 'Interface', $methodName);
    }

    /**
     * @return array
     */
    public function getProcessorModelMethodData(): array
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
                'Spryker\Glue\FooBar\Processor\FooBarProcessor',
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
                'Pyz\Glue\FooBar\Processor\FooBarProcessor',
                'bazQux',
            ],
        ];
    }
}
