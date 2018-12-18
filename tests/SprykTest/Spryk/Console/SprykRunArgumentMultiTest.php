<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Console;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Console
 * @group SprykRunArgumentMultiTest
 * Add your own group annotations below this line
 */
class SprykRunArgumentMultiTest extends Unit
{
    /**
     * @var \SprykTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsMultiArgument()
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'AddFacadeMethod',
            '--module' => 'FooBar',
            '--organization' => 'Spryker',
        ];

        $tester->execute($arguments);

        $pathToFacadeInterface = $this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/src/Spryker/Zed/FooBar/Business/FooBarFacadeInterface.php';
        $facadeInterfaceContent = file_get_contents($pathToFacadeInterface);
        $facadeInterfaceContent = ($facadeInterfaceContent) ?: '';

        static::assertRegExp('/\* Specification:/', $facadeInterfaceContent);
        static::assertRegExp('/\* - First specification line./', $facadeInterfaceContent);
        static::assertRegExp('/\* - Second specification line./', $facadeInterfaceContent);
    }
}
