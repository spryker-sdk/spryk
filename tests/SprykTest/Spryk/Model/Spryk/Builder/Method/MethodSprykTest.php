<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerTest\Spryk\Model\Spryk\Builder\Method;

use Codeception\Test\Unit;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Spryker\Spryk\Exception\EmptyFileException;
use Spryker\Spryk\Exception\ReflectionException;
use Spryker\Spryk\Model\Spryk\Builder\Method\MethodSpryk;
use Spryker\Spryk\Style\SprykStyleInterface;

/**
 * Auto-generated group annotations
 * @group SprykerTest
 * @group Spryk
 * @group Model
 * @group Builder
 * @group Method
 * @group MethodSprykTest
 * Add your own group annotations below this line
 */
class MethodSprykTest extends Unit
{
    const ARGUMENT_TARGET = '';
    const EMPTY_FILE_NAME = 'emptyFile';

    /**
     * @var \SprykTest\SprykTester
     */
    protected $tester;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        touch($this->tester->getRootDirectory() . static::EMPTY_FILE_NAME);
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenReflectionClassFilenameIsNull()
    {
        $this->expectException(ReflectionException::class);

        $methodSpryk = $this->buildMethodSprykMockWithEmptyFileNameOfReflectionClass();
        $methodSpryk->build(
            $this->tester->getSprykDefinition([MethodSpryk::ARGUMENT_TARGET => static::ARGUMENT_TARGET]),
            $this->getSprykStyleMock()
        );
    }

    /**
     * @return void
     */
    public function testBuildThrowsExceptionWhenTargetFileIsEmpty()
    {
        $this->expectException(EmptyFileException::class);

        $methodSpryk = $this->buildMethodSprykMockWithEmptyTargetFile();
        $methodSpryk->build(
            $this->tester->getSprykDefinition([MethodSpryk::ARGUMENT_TARGET => static::ARGUMENT_TARGET]),
            $this->getSprykStyleMock()
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildMethodSprykMockWithEmptyFileNameOfReflectionClass()
    {
        $mockBuilder = $this->getMockBuilder(MethodSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['getReflection']);

        $methodSprykMock = $mockBuilder->getMock();
        $methodSprykMock
            ->expects($this->once())
            ->method('getReflection')
            ->willReturn(
                $this->buildReflectionClassMock()
            );

        return $methodSprykMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface
     */
    protected function buildMethodSprykMockWithEmptyTargetFile()
    {
        $mockBuilder = $this->getMockBuilder(MethodSpryk::class)
            ->disableOriginalConstructor()
            ->setMethods(['getTargetFilename']);

        $methodSprykMock = $mockBuilder->getMock();
        $methodSprykMock
            ->expects($this->once())
            ->method('getTargetFilename')
            ->willReturn(
                codecept_data_dir() . static::EMPTY_FILE_NAME
            );

        return $methodSprykMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Roave\BetterReflection\Reflection\ReflectionClass
     */
    protected function buildReflectionClassMock()
    {
        $mockBuilder = $this->getMockBuilder(ReflectionClass::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFilename']);

        $reflectionClassMock = $mockBuilder->getMock();
        $reflectionClassMock->expects($this->once())->method('getFilename')->willReturn(null);

        return $reflectionClassMock;
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Spryker\Spryk\Style\SprykStyleInterface
     */
    protected function getSprykStyleMock()
    {
        $mockBuilder = $this->getMockBuilder(SprykStyleInterface::class);

        return $mockBuilder->getMock();
    }
}
