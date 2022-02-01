<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Navigation;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\XmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Navigation\NavigationSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

/**
 * Auto-generated group annotations
 *
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
    /**
     * @var string
     */
    public const TARGET_PATH_VALUE = 'emptyFile';

    /**
     * @var string
     */
    public const MODULE = 'module';

    /**
     * @var string
     */
    public const CONTROLLER = 'controller';

    /**
     * @var string
     */
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
        $this->markTestSkipped('Needs update after refactoring.');

        $navigationSpryk = $this->getNavigationSprykMockForFailedToLoadFromFile();

        $this->expectException(XmlException::class);

        $navigationSpryk->build(
            $this->tester->getSprykDefinition([]),
            $this->getSprykStyleMock(),
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function getNavigationSprykMockForFailedToLoadFromFile(): SprykBuilderInterface
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
    protected function getSprykStyleMock(): SprykStyleInterface
    {
        $mockBuilder = $this->getMockBuilder(SprykStyleInterface::class);

        return $mockBuilder->getMock();
    }
}
