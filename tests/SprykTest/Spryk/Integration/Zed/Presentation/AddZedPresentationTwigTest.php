<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Presentation;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Presentation
 * @group AddZedPresentationTwigTest
 * Add your own group annotations below this line
 */
class AddZedPresentationTwigTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedViewFile(): void
    {
        $this->tester->run($this, [
            '--moduleName' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }

    /**
     * @return void
     */
    public function testAddsZedViewFileWithFullyQualifiedNames(): void
    {
        $this->tester->run($this, [
            '--moduleName' => 'FooBar',
            '--controller' => ClassName::ZED_CONTROLLER,
            '--method' => 'indexAction',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Presentation/Index/index.twig');
    }
}
