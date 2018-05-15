<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;

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
     * @var \SprykerTest\SprykTester
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

        $targetFile = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/CatFace/src/Spryker/Zed/CatFace/Business/CatFaceFacade.php';
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

        $targetFile = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/CatFace/src/Spryker/Zed/CatFace/Business/CatFaceFacade.php';
        $this->assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);

        $this->assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
    }
}
