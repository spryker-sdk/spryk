<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
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
 *
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
    /**
     * @var string
     */
    public const TARGET_PATH_VALUE = 'emptyFile.yml';

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
        $sprykDefinition = $this->tester->getSprykDefinition([
            UpdateYmlSpryk::ARGUMENT_TARGET_PATH => static::TARGET_PATH_VALUE,
            UpdateYmlSpryk::ARGUMENT_ORGANIZATION => 'Spryker',
            UpdateYmlSpryk::ARGUMENT_MODULE => 'FooBar',
        ]);

        $updateYmlSpryk = $this->buildUpdateYmlSpryk();

        $this->expectException(YmlException::class);

        $updateYmlSpryk->runSpryk($sprykDefinition);
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected function getTemplateRendererMock(): TemplateRendererInterface
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

        /** @var \Codeception\Module\Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        $container = $symfony->_getContainer();
//        $container->set(TemplateRendererInterface::class, $templateRendererMock);
        $updateYmlSpryk = $this->tester->grabService(UpdateYmlSpryk::class);

//        $updateYmlSpryk = new UpdateYmlSpryk($templateRendererMock, $this->tester->getFileResolver(), $this->tester->getRootDirectory());

        return $updateYmlSpryk;
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
