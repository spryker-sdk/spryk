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
 * @group SprykRunPostSprykTest
 * Add your own group annotations below this line
 */
class SprykRunPostSprykTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testExecutesPostSprykAfterCalledSpryk()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'SprykWithPostSpryk',
        ];

        $tester->execute($arguments);

        static::assertDirectoryExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src');

        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/README.md');
    }
}
