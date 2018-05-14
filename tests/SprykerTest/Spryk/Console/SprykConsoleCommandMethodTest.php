<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykConsoleCommand;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykConsoleCommandMethodTest
 * Add your own group annotations below this line
 */
class SprykConsoleCommandMethodTest extends Unit
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
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'AddFacadeMethod',
        ];

        $tester->execute($arguments);

        $targetFile = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/Catface/src/Spryker/Zed/CatFace/Business/CatFaceFacade.php';
        $this->assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);

        $this->assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
    }

    /**
     * @return void
     */
    public function testAddsMethodOnlyOnce(): void
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'AddFacadeMethod',
        ];

        $tester->execute($arguments);
        $tester->execute($arguments);

        $targetFile = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/Catface/src/Spryker/Zed/CatFace/Business/CatFaceFacade.php';
        $this->assertFileExists($targetFile);
        $fileContent = file_get_contents($targetFile);

        $this->assertRegExp('/public function/', $fileContent, 'Expected that method was added to target but was not.');
    }
}
