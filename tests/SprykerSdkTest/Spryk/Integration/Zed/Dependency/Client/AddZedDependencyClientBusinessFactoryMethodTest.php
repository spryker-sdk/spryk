<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Zed\Dependency\Client;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Dependency
 * @group Client
 * @group AddZedDependencyClientBusinessFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddZedDependencyClientBusinessFactoryMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedDependencyClientDependencyMethodToBusinessFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->tester->assertClassHasMethod(ClassName::ZED_BUSINESS_FACTORY, 'getZipZapClient');
    }

    /**
     * @return void
     */
    public function testAddsZedDependencyClientDependencyMethodToBusinessFactoryOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_ZED_BUSINESS_FACTORY, 'getZipZapClient');
    }
}