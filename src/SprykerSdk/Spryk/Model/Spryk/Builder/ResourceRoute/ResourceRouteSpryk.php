<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\ResourceRoute;

use Roave\BetterReflection\BetterReflection;
use SprykerSdk\Spryk\Exception\EmptyFileException;
use SprykerSdk\Spryk\Exception\ReflectionException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class ResourceRouteSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET = 'target';
    public const ARGUMENT_TEMPLATE = 'template';
    public const ARGUMENT_METHOD_NAME = 'method';
    protected const ARGUMENT_RESOURCE_ROUTE_METHOD = 'resourceRouteMethod';

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
        return 'resourceRoute';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return (!$this->isRouteDeclared($sprykDefinition));
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

        $methodContent = $this->renderer->render(
            $templateName,
            $sprykDefinition->getArgumentCollection()->getArguments()
        );

        $search = 'return $resourceRouteCollection;';
        $positionOfReturnStatement = strrpos($targetFileContent, $search);

        if ($positionOfReturnStatement !== false) {
            $targetFileContent = substr_replace($targetFileContent, $methodContent, $positionOfReturnStatement, strlen($search));
        }

        $this->putTargetFileContent($sprykDefinition, $targetFileContent);

        $style->report(
            sprintf(
                'Added resource route declaration to "%s".',
                $this->getTargetArgument($sprykDefinition)
            )
        );
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
     * @return string
     */
    protected function getMethodName(SprykDefinitionInterface $sprykDefinition): string
    {
        $methodName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_METHOD_NAME)
            ->getValue();

        return $methodName;
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
    protected function getReflection(SprykDefinitionInterface $sprykDefinition)
    {
        $betterReflection = new BetterReflection();

        return $betterReflection->classReflector()->reflect($this->getTargetArgument($sprykDefinition));
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string|null
     */
    protected function getTargetFileNameFromReflectionClass(SprykDefinitionInterface $sprykDefinition)
    {
        $targetReflection = $this->getReflection($sprykDefinition);

        return $targetReflection->getFileName();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function isRouteDeclared(SprykDefinitionInterface $sprykDefinition): bool
    {
        $reflectionClass = $this->getReflection($sprykDefinition);
        $reflectionMethod = $reflectionClass->getMethod($this->getMethodName($sprykDefinition));
        $methodBody = $reflectionMethod->getBodyCode();
        $resourceRouteMethod = $this->getResourceRouteMethod($sprykDefinition);

        if (strpos($methodBody, '->add' . ucfirst($resourceRouteMethod) . '(') !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getResourceRouteMethod(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_RESOURCE_ROUTE_METHOD)
            ->getValue();
    }
}