<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;
use Spryker\Zed\FooBar\Business\FooBarFacade;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykRunMethodTest
 * Add your own group annotations below this line
 */
class SprykRunMethodTest extends Unit
{
    /**
     * @var \SprykTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMethod(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddFacadeMethod',
        ];

        $tester->execute($arguments);

        $targetFile = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src/Spryker/Zed/FooBar/Business/FooBarFacade.php';
        $this->assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);

        $this->assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
    }

    /**
     * @return void
     */
    public function testAddsMethodOnlyOnce(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddFacadeMethod',
        ];

        $tester->execute($arguments);
        $tester->execute($arguments);

        $targetFile = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src/Spryker/Zed/FooBar/Business/FooBarFacade.php';
        $this->assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);

        $this->assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
    }

    /**
     * @return void
     */
    public function testAddsApiAnnotation(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddMethodWithApiTag',
        ];

        $tester->execute($arguments);
        $expectedDocBlock = '/**
 * @api
 *
 * @return bool
 */';
        $this->tester->assertDocBlockForClassMethod($expectedDocBlock, FooBarFacade::class, 'doSomething');
    }

    /**
     * @return void
     */
    public function testAddsApiAndInheritdocAnnotations(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddMethodWithApiAndInheritdocTag',
        ];

        $tester->execute($arguments);
        $expectedDocBlock = '/**
 * {@inheritdoc}
 *
 * @api
 *
 * @return bool
 */';
        $this->tester->assertDocBlockForClassMethod($expectedDocBlock, FooBarFacade::class, 'doSomething');
    }
}
