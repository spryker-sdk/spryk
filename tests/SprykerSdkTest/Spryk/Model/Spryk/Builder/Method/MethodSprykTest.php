<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Method;

use Codeception\Test\Unit;
use PHPStan\BetterReflection\Reflection\ReflectionClass;
use SprykerSdk\Spryk\Exception\EmptyFileException;
use SprykerSdk\Spryk\Exception\ReflectionException;
use SprykerSdk\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

/**
 * Auto-generated group annotations
 *
 * @group SprykerSdkTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Method
 * @group MethodSprykTest
 * Add your own group annotations below this line
 */
class MethodSprykTest extends Unit
{
    /**
     * @var string
     */
    public const ARGUMENT_TARGET = '';

    /**
     * @var string
     */
    public const EMPTY_FILE_NAME = 'emptyFile';

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

        file_put_contents($this->tester->getRootDirectory() . static::EMPTY_FILE_NAME, '');
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenReflectionClassFilenameIsNull(): void
    {
        $this->markTestSkipped('Needs update after refactoring.');

        $methodSpryk = $this->buildMethodSprykMockWithEmptyFileNameOfReflectionClass();

        $this->expectException(ReflectionException::class);

        $methodSpryk->build(
            $this->tester->getSprykDefinition([MethodSpryk::ARGUMENT_TARGET => static::ARGUMENT_TARGET]),
            $this->getSprykStyleMock(),
        );
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenTargetFileIsEmpty(): void
    {
        $this->markTestSkipped('Needs update after refactoring.');

        $methodSpryk = $this->buildMethodSprykMockWithEmptyTargetFile();

        $this->expectException(EmptyFileException::class);

        $methodSpryk->build(
            $this->tester->getSprykDefinition([MethodSpryk::ARGUMENT_TARGET => static::ARGUMENT_TARGET]),
            $this->getSprykStyleMock(),
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildMethodSprykMockWithEmptyFileNameOfReflectionClass(): SprykBuilderInterface
    {
        $mockBuilder = $this->getMockBuilder(MethodSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['getReflection']);

        $methodSprykMock = $mockBuilder->getMock();
        $methodSprykMock
            ->expects(Unit::once())
            ->method('getReflection')
            ->willReturn(
                $this->buildReflectionClassMock(),
            );

        return $methodSprykMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildMethodSprykMockWithEmptyTargetFile(): SprykBuilderInterface
    {
        $mockBuilder = $this->getMockBuilder(MethodSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTargetFilename']);

        $methodSprykMock = $mockBuilder->getMock();
        $methodSprykMock
            ->expects(Unit::once())
            ->method('getTargetFilename')
            ->willReturn(
                codecept_data_dir() . static::EMPTY_FILE_NAME,
            );

        return $methodSprykMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\PHPStan\BetterReflection\Reflection\ReflectionClass
     */
    protected function buildReflectionClassMock(): ReflectionClass
    {
        $mockBuilder = $this->getMockBuilder(ReflectionClass::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFilename']);

        $reflectionClassMock = $mockBuilder->getMock();
        $reflectionClassMock->expects(Unit::once())->method('getFilename')->willReturn(null);

        return $reflectionClassMock;
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
