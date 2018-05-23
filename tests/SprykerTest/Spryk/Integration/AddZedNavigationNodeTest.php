<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Integration;

use Codeception\Test\Unit;
use Spryker\Spryk\Console\SprykRunConsole;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group AddZedNavigationNodeTest
 * Add your own group annotations below this line
 */
class AddZedNavigationNodeTest extends Unit
{
    protected const SPRYK_NAME = 'AddZedNavigationNode';

    /**
     * @var \SprykerTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFile(): void
    {
        $command = new SprykRunConsole();
        $tester = $this->tester->getConsoleTester($command, static::SPRYK_NAME);

        $arguments = [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => static::SPRYK_NAME,
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ];

        $tester->execute($arguments, ['interactive' => false]);
        $pathToNavigationSchema = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/navigation.xml';
        $this->assertFileExists($pathToNavigationSchema);
        $xmlContent = file_get_contents($pathToNavigationSchema);

        $this->assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        $this->assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        $this->assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }
}
