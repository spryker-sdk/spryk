<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Template;

use Codeception\Test\Unit;
use SprykerSdk\Spryk\Exception\YmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\UpdateYmlSpryk;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

/**
 * Auto-generated group annotations
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Template
 * @group UpdateYmlSprykTest
 * Add your own group annotations below this line
 */
class UpdateYmlSprykTest extends Unit
{
    public const TARGET_PATH_VALUE = 'emptyFile';

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

        file_put_contents($this->tester->getRootDirectory() . static::TARGET_PATH_VALUE, '');
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenYamlContentIsEmpty(): void
    {
        $this->expectException(YmlException::class);

        $sprykDefinition = $this->tester->getSprykDefinition([
                UpdateYmlSpryk::ARGUMENT_TARGET_PATH => static::TARGET_PATH_VALUE,
        ]);

        $updateYmlSpryk = $this->buildUpdateYmlSpryk();
        $updateYmlSpryk->build(
            $sprykDefinition,
            $this->getSprykStyleMock()
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected function getTemplateRendererMock()
    {
        $mockBuilder = $this->getMockBuilder(TemplateRendererInterface::class);

        return $mockBuilder->getMock();
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildUpdateYmlSpryk(): SprykBuilderInterface
    {
        $templateRendererMock = $this->getTemplateRendererMock();
        $updateYmlSpryk = new UpdateYmlSpryk($templateRendererMock, $this->tester->getRootDirectory());

        return $updateYmlSpryk;
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
