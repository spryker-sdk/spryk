<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykTest\Spryk\Integration\Zed\Communication;

use Codeception\Test\Unit;
use SprykTest\Module\ClassName;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Integration
 * @group Zed
 * @group Communication
 * @group AddZedNavigationNodeTest
 * Add your own group annotations below this line
 */
class AddZedNavigationNodeTest extends Unit
{
    /**
     * @var \SprykTest\SprykIntegrationTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFile(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => 'Index',
            '--method' => 'index',
        ]);

        $pathToNavigationSchema = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/navigation.xml';
        static::assertFileExists($pathToNavigationSchema);
        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';
        static::assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        static::assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        static::assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }

    /**
     * @return void
     */
    public function testAddsZedNavigationSchemaFileWithFullyQualifiedNames(): void
    {
        $this->tester->run($this, [
            '--module' => 'FooBar',
            '--controller' => ClassName::CONTROLLER_ZED,
            '--method' => 'indexAction',
        ]);

        $pathToNavigationSchema = $this->tester->getModuleDirectory() . 'src/Spryker/Zed/FooBar/Communication/navigation.xml';
        static::assertFileExists($pathToNavigationSchema);
        $xmlContent = file_get_contents($pathToNavigationSchema);
        $xmlContent = ($xmlContent) ?: '';
        static::assertRegExp('/\<bundle\>foo-bar\<\/bundle\>/', $xmlContent);
        static::assertRegExp('/\<controller\>index\<\/controller\>/', $xmlContent);
        static::assertRegExp('/\<action\>index\<\/action\>/', $xmlContent);
    }
}
