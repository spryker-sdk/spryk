<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Communication\Controller;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group Controller
 * @group AddZedCommunicationControllerTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationControllerTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedControllerFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Controller/IndexController.php');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerFileOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Controller/IndexController.php');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerFileFromFullyQualifiedControllerClassName(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::ZED_CONTROLLER,
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Controller/IndexController.php');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerFileFromFullyQualifiedControllerClassNameOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::PROJECT_ZED_CONTROLLER,
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Controller/IndexController.php');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerFileAndRemovesControllerSuffix(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'IndexController',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/Controller/IndexController.php');
    }

    /**
     * @return void
     */
    public function testAddsZedControllerFileAndRemovesControllerSuffixOnProjectLayer(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'IndexController',
            '--mode' => 'project',
        ]);

        static::assertFileExists($this->tester->getProjectModuleDirectory() . 'Communication/Controller/IndexController.php');
    }
}
