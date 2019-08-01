<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group AddGlueResourceRestResponseBuilderFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddGlueResourceRestResponseBuilderFactoryMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @dataProvider getFactoryMethodData
     *
     * @param array $params
     * @param string $className
     * @param string $methodName
     * @param string $expectedBody
     *
     * @return void
     */
    public function testAddsGlueFactoryMethod(
        array $params,
        string $className,
        string $methodName,
        string $expectedBody
    ): void {
        $this->tester->run($this, $params);
        $this->tester->assertMethodBody($className, $methodName, $expectedBody);
    }

    /**
     * @return array
     */
    public function getFactoryMethodData(): array
    {
        return [
            [
                [
                    '--module' => 'FooBar',
                    '--subDirectory' => 'RestResponseBuilder',
                    '--className' => 'FooBarRestResponseBuilder',
                    '--output' => 'Spryker\Glue\FooBar\Processor\RestResponseBuilder\FooBarRestResponseBuilder',
                ],
                'Spryker\Glue\FooBar\FooBarFactory',
                'createFooBarRestResponseBuilder',
                'return new \Spryker\Glue\FooBar\Processor\RestResponseBuilder\FooBarRestResponseBuilder();',
            ],
            [
                [
                    '--module' => 'FooBar',
                    '--subDirectory' => 'RestResponseBuilder',
                    '--className' => 'FooBarRestResponseBuilder',
                    '--output' => 'Pyz\Glue\FooBar\Processor\RestResponseBuilder\FooBarRestResponseBuilder',
                    '--mode' => 'project',
                ],
                'Pyz\Glue\FooBar\FooBarFactory',
                'createFooBarRestResponseBuilder',
                'return new \Pyz\Glue\FooBar\Processor\RestResponseBuilder\FooBarRestResponseBuilder();',
            ],
        ];
    }
}
