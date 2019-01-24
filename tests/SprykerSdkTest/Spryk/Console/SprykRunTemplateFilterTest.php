<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Console
 * @group SprykRunTemplateFilterTest
 * Add your own group annotations below this line
 */
class SprykRunTemplateFilterTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykConsoleTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testUsesCamelCaseToDashFilter(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'TemplateWithFilter',
        ];

        $tester->setInputs(['FooBar']);
        $tester->execute($arguments);

        static::assertFileExists($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer-with-filter.json');
        $fileContent = file_get_contents($this->tester->getRootDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer-with-filter.json');
        $fileContent = ($fileContent) ?: '';

        static::assertRegExp('/"name": "spryker\/foo-bar"/', $fileContent);
    }
}
