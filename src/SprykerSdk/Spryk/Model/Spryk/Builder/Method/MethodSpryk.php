<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Method;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionClass;
use SprykerSdk\Spryk\Exception\ArgumentNotFoundException;
use SprykerSdk\Spryk\Exception\EmptyFileException;
use SprykerSdk\Spryk\Exception\NotAFullyQualifiedClassNameException;
use SprykerSdk\Spryk\Exception\ReflectionException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class MethodSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET = 'target';
    public const ARGUMENT_TARGET_PATH = 'targetPath';
    public const ARGUMENT_TARGET_FILE_NAME = 'targetFileName';
    public const ARGUMENT_TEMPLATE = 'template';
    public const ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN = 'fqcnPattern';

    public const ARGUMENT_METHOD_NAME_CANDIDATES = [
        'method',
        'controllerMethod',
        'factoryMethod',
        'facadeMethod',
        'modelMethod',
        'providerMethod',
        'clientMethod',
        'configMethod',
        'entityManagerMethod',
        'repositoryMethod',
    ];

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     */
    public function __construct(TemplateRendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'method';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return (!$this->methodExists($sprykDefinition));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetFileContent = $this->getTargetFileContent($sprykDefinition);

        $templateName = $this->getTemplateName($sprykDefinition);

        $argumentCollection = $sprykDefinition->getArgumentCollection();
        $methodName = $this->getMethodName($sprykDefinition);

        $methodArgument = new Argument();
        $methodArgument
            ->setName('method')
            ->setValue($methodName);

        $argumentCollection->addArgument($methodArgument);

        $methodContent = $this->renderer->render(
            $templateName,
            $sprykDefinition->getArgumentCollection()->getArguments()
        );

        $search = '}';
        $positionOfClosingBrace = strrpos($targetFileContent, $search);

        if ($positionOfClosingBrace !== false) {
            $targetFileContent = substr_replace($targetFileContent, $methodContent, $positionOfClosingBrace - 1, strlen($search));
        }

        $this->putTargetFileContent($sprykDefinition, $targetFileContent);

        $style->report(sprintf(
            'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
            $this->getMethodName($sprykDefinition),
            $sprykDefinition->getArgumentCollection()->getArgument('target')
        ));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function methodExists(SprykDefinitionInterface $sprykDefinition): bool
    {
        $reflectionClass = $this->getReflection($sprykDefinition);
        $methodName = $this->getMethodName($sprykDefinition);

        if ($reflectionClass->hasMethod($methodName) && $reflectionClass->getMethod($methodName)->getDeclaringClass() === $reflectionClass) {
            return true;
        }

        return false;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetArgument(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTemplateName(SprykDefinitionInterface $sprykDefinition): string
    {
        $templateName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TEMPLATE)
            ->getValue();

        return $templateName;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\ArgumentNotFoundException
     *
     * @return string
     */
    protected function getMethodName(SprykDefinitionInterface $sprykDefinition): string
    {
        $argumentCollection = $sprykDefinition->getArgumentCollection();

        foreach (static::ARGUMENT_METHOD_NAME_CANDIDATES as $methodNameCandidate) {
            if ($argumentCollection->hasArgument($methodNameCandidate)) {
                return $argumentCollection->getArgument($methodNameCandidate);
            }
        }

        throw new ArgumentNotFoundException(sprintf(
            'Could not find method argument value. You need to add on of "%s" as method argument to your spryk "%s".',
            implode(', ', static::ARGUMENT_METHOD_NAME_CANDIDATES),
            $sprykDefinition->getSprykName()
        ));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\EmptyFileException
     *
     * @return string
     */
    protected function getTargetFileContent(SprykDefinitionInterface $sprykDefinition): string
    {
        $targetFileName = $this->getTargetFileName($sprykDefinition);

        $targetFileContent = file_get_contents($targetFileName);
        if ($targetFileContent === false || strlen($targetFileContent) === 0) {
            throw new EmptyFileException(sprintf('Target file "%s" seems to be empty', $targetFileName));
        }

        return $targetFileContent;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\ReflectionException
     *
     * @return string
     */
    protected function getTargetFileName(SprykDefinitionInterface $sprykDefinition): string
    {
        $targetFilename = $this->getTargetFileNameFromReflectionClass($sprykDefinition);

        if ($targetFilename === null) {
            throw new ReflectionException('Filename is not expected to be null!');
        }

        return $targetFilename;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param string $newContent
     *
     * @return void
     */
    protected function putTargetFileContent(SprykDefinitionInterface $sprykDefinition, string $newContent): void
    {
        $targetFilename = $this->getTargetFileName($sprykDefinition);

        file_put_contents($targetFilename, $newContent);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionClass
     */
    protected function getReflection(SprykDefinitionInterface $sprykDefinition): ReflectionClass
    {
        $targetClassName = $this->getTargetClassName($sprykDefinition);
        $this->assertFullyQualifiedClassName($targetClassName);

        $targetClassName = str_replace(DIRECTORY_SEPARATOR, '\\', $targetClassName);

        $betterReflection = new BetterReflection();

        return $betterReflection->classReflector()->reflect($targetClassName);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetClassName(SprykDefinitionInterface $sprykDefinition): string
    {
        $className = $this->getTargetArgument($sprykDefinition);
        if (strpos($className, '\\') === false && $sprykDefinition->getArgumentCollection()->hasArgument(static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN)) {
            $className = $sprykDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN)->getValue();
        }
        $className = str_replace(DIRECTORY_SEPARATOR, '\\', $className);

        $this->assertFullyQualifiedClassName($className);

        return $className;
    }

    /**
     * @param string $className
     *
     * @throws \SprykerSdk\Spryk\Exception\NotAFullyQualifiedClassNameException
     *
     * @return void
     */
    protected function assertFullyQualifiedClassName(string $className): void
    {
        if (strpos($className, '\\') === false) {
            throw new NotAFullyQualifiedClassNameException(sprintf(
                'Expected a fully qualified class name for reflection but got "%s". ' .
                'Make sure you pass a fully qualified class name in the "%s" argument or use the "%s" argument with a value like "%s" in your spryk ' .
                'to be able to compute the fully qualified class name from the given arguments.',
                $className,
                static::ARGUMENT_TARGET,
                static::ARGUMENT_FULLY_QUALIFIED_CLASS_NAME_PATTERN,
                '{{ organization }}\\Zed\\{{ module }}\\Business\\{{ subDirectory | convertToClassNameFragment }}\\{{ className }}'
            ));
        }
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string|null
     */
    protected function getTargetFileNameFromReflectionClass(SprykDefinitionInterface $sprykDefinition): ?string
    {
        $targetReflection = $this->getReflection($sprykDefinition);

        return $targetReflection->getFileName();
    }
}
