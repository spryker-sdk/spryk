<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Integration\Yves\Dependency\Service;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Integration
 * @group Yves
 * @group Dependency
 * @group Service
 * @group AddYvesDependencyServiceInterfaceTest
 * Add your own group annotations below this line
 */
class AddYvesDependencyServiceInterfaceTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsYvesDependencyServiceInterface(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Yves/FooBar/Dependency/Service/FooBarToZipZapServiceInterface.php');
    }

    /**
     * @return void
     */
    public function testAddsYvesDependencyServiceInterfaceOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--dependentModule' => 'ZipZap',
            '--mode' => 'project',
        ]);

        static::assertFileExists(
            $this->tester->getProjectModuleDirectory('FooBar', 'Yves')
            . 'Dependency/Service/FooBarToZipZapServiceInterface.php'
        );
    }
}
