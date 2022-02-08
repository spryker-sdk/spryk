<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Spryk\Console;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 *
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
    public function testUsesDasherizeFilter(): void
    {
        /** @var \SprykerSdk\Spryk\Console\SprykRunConsole $command */
        $command = $this->tester->getClass(SprykRunConsole::class);
        $tester = $this->tester->getConsoleTester($command);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => 'TemplateWithFilter',
            '--mode' => 'core',
        ];

        $tester->setInputs(['FooBar']);
        $tester->execute($arguments);

        $this->assertFileExists($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer-with-filter.json');
        $fileContent = file_get_contents($this->tester->getVirtualDirectory() . 'vendor/spryker/spryker/Bundles/FooBar/composer-with-filter.json');
        $fileContent = ($fileContent) ?: '';

        $this->assertRegExp('/"name": "spryker\/foo-bar"/', $fileContent);
    }
}
