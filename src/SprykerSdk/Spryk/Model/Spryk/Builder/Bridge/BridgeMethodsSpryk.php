<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Bridge;

use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class BridgeMethodsSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET = 'target';
    public const ARGUMENT_TEMPLATE = 'template';
    public const ARGUMENT_SOURCE_CLASS = 'sourceClass';
    public const ARGUMENT_METHODS = 'methods';
    public const ARGUMENT_DEPENDENT_MODULE = 'dependentModule';
    public const ARGUMENT_DEPENDENCY_TYPE = 'dependencyType';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface
     */
    protected $reflectionHelper;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface
     */
    protected $methodHelper;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\ReflectionHelperInterface $reflectionHelper
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Bridge\Reflection\MethodHelperInterface $methodHelper
     */
    public function __construct(TemplateRendererInterface $renderer, ReflectionHelperInterface $reflectionHelper, MethodHelperInterface $methodHelper)
    {
        $this->renderer = $renderer;
        $this->reflectionHelper = $reflectionHelper;
        $this->methodHelper = $methodHelper;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'bridgeMethods';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetFileContent = $this->reflectionHelper->getFileContentByClassName(
            $this->getTargetClassName($sprykDefinition)
        );

        $reflectionMethods = $this->getReflectionMethods($sprykDefinition);

        foreach ($reflectionMethods as $reflectionMethod) {
            $returnTypeAnnotation = $this->getReturnTypeAnnotationFromDocBlock($reflectionMethod->getDocComment());

            $arguments = [
                'docBlock' => $this->cleanMethodDocBlock($reflectionMethod->getDocComment()),
                'methodName' => $reflectionMethod->getName(),
                'dependentModule' => $this->getStringArgumentValue(static::ARGUMENT_DEPENDENT_MODULE, $sprykDefinition),
                'dependencyType' => $this->getStringArgumentValue(static::ARGUMENT_DEPENDENCY_TYPE, $sprykDefinition),
                'return' => ($returnTypeAnnotation !== 'void'),
                'methodReturnType' => $this->methodHelper->getMethodReturnType($reflectionMethod),
                'parameter' => $this->methodHelper->getParameter($reflectionMethod),
                'parameterWithoutTypes' => $this->methodHelper->getParameterNames($reflectionMethod),
            ];

            $methodContent = $this->renderer->render(
                $this->getStringArgumentValue(static::ARGUMENT_TEMPLATE, $sprykDefinition),
                $arguments
            );

            $search = '}';
            $positionOfClosingBrace = strrpos($targetFileContent, $search);

            if ($positionOfClosingBrace !== false) {
                $targetFileContent = substr_replace($targetFileContent, $methodContent, $positionOfClosingBrace - 1, strlen($search));
            }

            $style->report(sprintf(
                'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
                $reflectionMethod->getName(),
                $sprykDefinition->getArgumentCollection()->getArgument('target')
            ));
        }

        $this->putTargetFileContent($sprykDefinition, $targetFileContent);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionMethod[]
     */
    protected function getReflectionMethods(SprykDefinitionInterface $sprykDefinition): array
    {
        $targetReflectionClass = $this->reflectionHelper->getReflectionClassByClassName(
            $this->getTargetClassName($sprykDefinition)
        );

        $sourceReflectionClass = $this->reflectionHelper->getReflectionClassByClassName(
            $this->getSourceClassName($sprykDefinition)
        );

        $methodNames = $this->getMethodNames($sprykDefinition);

        $targetImmediateMethods = $targetReflectionClass->getImmediateMethods();

        $reflectionMethods = [];
        foreach ($methodNames as $methodName) {
            if (!isset($targetImmediateMethods[$methodName])) {
                $reflectionMethods[] = $sourceReflectionClass->getMethod($methodName);
            }
        }

        return $reflectionMethods;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetClassName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->getStringArgumentValue(static::ARGUMENT_TARGET, $sprykDefinition);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getSourceClassName(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->getStringArgumentValue(static::ARGUMENT_SOURCE_CLASS, $sprykDefinition);
    }

    /**
     * @param string $argumentName
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getStringArgumentValue(string $argumentName, SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument($argumentName)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function getMethodNames(SprykDefinitionInterface $sprykDefinition): array
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_METHODS)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param string $newContent
     *
     * @return void
     */
    protected function putTargetFileContent(SprykDefinitionInterface $sprykDefinition, string $newContent): void
    {
        $targetFilePath = $this->reflectionHelper->getFilePathByClassName(
            $this->getTargetClassName($sprykDefinition)
        );

        file_put_contents($targetFilePath, $newContent);
    }

    /**
     * @param string $docComment
     *
     * @return string
     */
    protected function cleanMethodDocBlock(string $docComment): string
    {
        $docCommentWithoutExtras = preg_replace('/.+?(?=@param|@return)/ms', '/**' . PHP_EOL . ' * ', $docComment, 1);

        if ($docCommentWithoutExtras !== null) {
            $docComment = $docCommentWithoutExtras;
        }

        return $this->addSpacingToDocComment($docComment);
    }

    /**
     * @param string $docComment
     *
     * @return string
     */
    protected function addSpacingToDocComment(string $docComment): string
    {
        $docCommentLines = explode(PHP_EOL, $docComment);
        array_walk($docCommentLines, function (&$docCommentLine) {
            $docCommentLine = str_repeat(' ', 4) . $docCommentLine;
        });

        return implode(PHP_EOL, $docCommentLines);
    }

    /**
     * @param string $docComment
     *
     * @return string
     */
    protected function getReturnTypeAnnotationFromDocBlock(string $docComment): string
    {
        preg_match('/@return (.+)/', $docComment, $returnType);

        if (!$returnType) {
            return '';
        }

        return $returnType[1];
    }
}
