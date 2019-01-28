<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Template\Renderer;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\TwigException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Template
 * @group Renderer
 * @group TemplateRendererTest
 * Add your own group annotations below this line
 */
class TemplateRendererTest extends Unit
{
    /**
     * @var \SprykerSdkTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function testGetSourceThrowsExceptionWhenLoaderNotInstanceOfSourceContextLoader(): void
    {
        $this->expectException(TwigException::class);

        $templateRendererMock = $this->getTemplateRendererMock();
        $templateRendererMock->getSource('foo');
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected function getTemplateRendererMock()
    {
        $mockBuilder = $this->getMockBuilder(TemplateRenderer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getLoader']);

        $templateRendererMock = $mockBuilder->getMock();
        $templateRendererMock->expects(static::once())->method('getLoader')->willReturn(false);

        return $templateRendererMock;
    }
}
