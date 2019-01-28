<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunMethodTest
 * Add your own group annotations below this line
 */
class SprykRunMethodTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
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
        static::assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);
        $fileContent = ($fileContent) ?: '';

        static::assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
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
        static::assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);
        $fileContent = ($fileContent) ?: '';

        static::assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
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
        $this->tester->assertDocBlockForClassMethod($expectedDocBlock, 'Spryker\Zed\FooBar\Business\FooBarFacade', 'doSomething');
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
        $this->tester->assertDocBlockForClassMethod($expectedDocBlock, 'Spryker\Zed\FooBar\Business\FooBarFacade', 'doSomething');
    }
}
