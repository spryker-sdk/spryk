<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Template\Renderer;

use Codeception\Test\Unit;
use Spryker\Spryk\Exception\TwigException;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;

/**
 * Auto-generated group annotations
 * @group SprykerTest
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
     * @var \SprykTest\SprykTester
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
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected function getTemplateRendererMock()
    {
        $mockBuilder = $this->getMockBuilder(TemplateRenderer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getLoader']);

        $templateRendererMock = $mockBuilder->getMock();
        $templateRendererMock->expects($this->once())->method('getLoader')->willReturn(false);

        return $templateRendererMock;
    }
}
