<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Navigation;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\XmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Navigation\NavigationSpryk;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Navigation
 * @group NavigationSprykTest
 * Add your own group annotations below this line
 */
class NavigationSprykTest extends Unit
{
    public const TARGET_PATH_VALUE = 'emptyFile';
    public const MODULE = 'module';
    public const CONTROLLER = 'controller';
    public const ACTION = 'action';

    /**
     * @var \SprykerSdkTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        file_put_contents($this->tester->getRootDirectory() . static::TARGET_PATH_VALUE, '<navigation><module><pages></pages></module></navigation>');
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenNotSimpleXmlElement(): void
    {
        $this->expectException(XmlException::class);

        $navigationSpryk = $this->getNavigationSprykMockForFailedToLoadFromFile();
        $navigationSpryk->build(
            $this->tester->getSprykDefinition([]),
            $this->getSprykStyleMock()
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function getNavigationSprykMockForFailedToLoadFromFile()
    {
        $mockBuilder = $this->getMockBuilder(NavigationSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['loadXmlFromFile']);

        $navigationMock = $mockBuilder->getMock();
        $navigationMock->expects(static::once())->method('loadXmlFromFile')->willReturn(false);

        return $navigationMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected function getSprykStyleMock()
    {
        $mockBuilder = $this->getMockBuilder(SprykStyleInterface::class);

        return $mockBuilder->getMock();
    }
}
