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
 * @group SprykConsoleCommandTemplateFilterTest
 * Add your own group annotations below this line
 */
class SprykConsoleCommandTemplateFilterTest extends Unit
{
    /**
     * @var \SprykerTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testUsesCamelCaseToDashFilter(): void
    {
        $command = new SprykConsoleCommand();
        $tester = $this->tester->getCommandTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykConsoleCommand::ARGUMENT_SPRYK => 'TemplateWithFilter',
        ];

        $tester->setInputs(['FooBar']);
        $tester->execute($arguments);

        $this->assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer-with-filter.json');

        $this->assertRegExp(
            '/"name": "spryker\/foo-bar"/',
            file_get_contents($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer-with-filter.json')
        );
    }
}
