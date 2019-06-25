<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Integration\Glue\Plugin\GlueApplication;

use Codeception\Test\Unit;
use Roave\BetterReflection\BetterReflection;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Glue
 * @group Plugin
 * @group GlueApplication
 * @group AddGlueResourceRouteTest
 * Add your own group annotations below this line
 */
class AddGlueResourceRouteTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsGlueResource(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceType' => 'foo-bars',
            '--resourceRouteMethod' => 'get',
            '--modelName' => 'FooBar',
            '--modelSuffix' => 'Reader',
            '--mode' => 'core',
        ]);

        $this->assertRouteAdded(
            '\Spryker\Glue\FooBar\Plugin\GlueApplication\FooBarsResourceRoutePlugin',
            'get'
        );
    }

    /**
     * @return void
     */
    public function testAddsGlueResourceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--resourceRouteMethod' => 'get',
            '--resourceType' => 'foo-bars',
            '--modelName' => 'FooBar',
            '--modelSuffix' => 'Reader',
            '--mode' => 'project',
        ]);

        $this->assertRouteAdded(
            '\Pyz\Glue\FooBar\Plugin\GlueApplication\FooBarsResourceRoutePlugin',
            'get'
        );
    }

    /**
     * @param string $className
     * @param string $resourceRouteMethod
     *
     * @return void
     */
    protected function assertRouteAdded(string $className, string $resourceRouteMethod): void
    {
        $reflection = new BetterReflection();
        $classReflection = $reflection->classReflector()->reflect($className);
        $methodReflection = $classReflection->getMethod('configure');

        $this->assertContains('->add' . ucfirst($resourceRouteMethod) . '(', $methodReflection->getBodyCode());
    }
}
