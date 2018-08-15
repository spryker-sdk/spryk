<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration;

use Codeception\Test\Unit;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedCommunicationFactoryTest
 * Add your own group annotations below this line
 */
class AddZedCommunicationFactoryTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedCommunicationFactoryFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
        ]);

        static::assertFileExists($this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/FooBarCommunicationFactory.php');
    }
}
