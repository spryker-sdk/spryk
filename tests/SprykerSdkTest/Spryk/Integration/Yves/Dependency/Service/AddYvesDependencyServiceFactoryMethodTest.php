<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Service;

use Codeception\Test\Unit;
use SprykerSdkTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Service
 * @group AddYvesDependencyServiceFactoryMethodTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyServiceFactoryMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesDependencyServiceDependencyMethodToFactory(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        $this->tester->assertClassHasMethod(ClassName::YVES_FACTORY, 'getZipZapService');
    }

    /**
     * @return void
     */
    public function testAddsYvesDependencyServiceDependencyMethodToFactoryOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        $this->tester->assertClassHasMethod(ClassName::PROJECT_YVES_FACTORY, 'getZipZapService');
    }
}
