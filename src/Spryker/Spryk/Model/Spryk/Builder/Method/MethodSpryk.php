<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Method;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionClass;
use Spryker\Spryk\Exception\EmptyFileException;
use Spryker\Spryk\Exception\ReflectionException;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;

class MethodSpryk implements SprykBuilderInterface
{
    const ARGUMENT_TARGET = 'target';
    const ARGUMENT_TARGET_PATH = 'targetPath';
    const ARGUMENT_TARGET_FILE_NAME = 'targetFileName';
    const ARGUMENT_TEMPLATE = 'template';
    const ARGUMENT_METHOD_NAME = 'method';

    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return (!$this->methodExists($sprykDefinition));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
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

        $search = '}';
        $positionOfClosingBrace = strrpos($targetFileContent, $search);

        if ($positionOfClosingBrace !== false) {
            $targetFileContent = substr_replace($targetFileContent, $methodContent, $positionOfClosingBrace - 1, strlen($search));
        }

        $this->putTargetFileContent($sprykDefinition, $targetFileContent);

        $style->report(sprintf(
            'Added method "<fg=green>%s</>" to "<fg=green>%s</>"',
            $sprykDefinition->getArgumentCollection()->getArgument('method'),
            $sprykDefinition->getArgumentCollection()->getArgument('target')
        ));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function methodExists(SprykDefinitionInterface $sprykDefinition): bool
    {
        $targetFileContent = $this->getTargetFileContent($sprykDefinition);
        $methodToCheck = sprintf('public function %s(', $this->getMethodName($sprykDefinition));

        if (strpos($targetFileContent, $methodToCheck) !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \Spryker\Spryk\Exception\EmptyFileException
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \Spryker\Spryk\Exception\ReflectionException
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionClass|\Roave\BetterReflection\Reflection\Reflection
     */
    protected function getReflection(SprykDefinitionInterface $sprykDefinition)
    {
        $betterReflection = new BetterReflection();

        return $betterReflection->classReflector()->reflect($this->getTargetArgument($sprykDefinition));
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string|null
     */
    protected function getTargetFileNameFromReflectionClass(SprykDefinitionInterface $sprykDefinition)
    {
        $targetReflection = $this->getReflection($sprykDefinition);
        if (!($targetReflection instanceof ReflectionClass)) {
            return null;
        }

        return $targetReflection->getFileName();
    }
}
