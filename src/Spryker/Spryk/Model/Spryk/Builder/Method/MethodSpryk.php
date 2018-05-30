<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Method;

use Roave\BetterReflection\BetterReflection;
use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;

class MethodSpryk implements SprykBuilderInterface
{
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
    const ARGUMENT_TARGET = 'target';

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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykerDefinition): bool
    {
        return (!$this->methodExists($sprykerDefinition));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykerDefinition, SprykStyleInterface $style): void
    {
        $targetFileContent = $this->getTargetFileContent($sprykerDefinition);

        $templateName = $this->getTemplateName($sprykerDefinition);

        $methodContent = $this->renderer->render(
            $templateName,
            $sprykerDefinition->getArgumentCollection()->getArguments()
        );

        $search = '}';
        $positionOfClosingBrace = strrpos($targetFileContent, $search);

        if ($positionOfClosingBrace !== false) {
            $targetFileContent = substr_replace($targetFileContent, $methodContent, $positionOfClosingBrace - 1, strlen($search));
        }

        $this->putTargetFileContent($sprykerDefinition, $targetFileContent);

        $style->report(sprintf(
            'Added method <fg=green>%s</> to <fg=green>%s</>',
            $sprykerDefinition->getArgumentCollection()->getArgument('method'),
            $sprykerDefinition->getArgumentCollection()->getArgument('target')
        ));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return bool
     */
    protected function methodExists(SprykDefinitionInterface $sprykerDefinition): bool
    {
        $targetFileContent = $this->getTargetFileContent($sprykerDefinition);
        $methodToCheck = sprintf('public function %s(', $this->getMethodName($sprykerDefinition));

        if (strpos($targetFileContent, $methodToCheck) !== false) {
            return true;
        }

        return false;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getTargetArgument(SprykDefinitionInterface $sprykerDefinition): string
    {
        return $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET)
            ->getValue();
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getTemplateName(SprykDefinitionInterface $sprykerDefinition): string
    {
        $templateName = $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TEMPLATE)
            ->getValue();

        return $templateName;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getMethodName(SprykDefinitionInterface $sprykerDefinition): string
    {
        $methodName = $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_METHOD_NAME)
            ->getValue();

        return $methodName;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getTargetFileContent(SprykDefinitionInterface $sprykerDefinition): string
    {
        $targetReflection = $this->getReflection($sprykerDefinition);

        return file_get_contents($targetReflection->getFileName());
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     * @param string $newContent
     *
     * @return void
     */
    protected function putTargetFileContent(SprykDefinitionInterface $sprykerDefinition, string $newContent): void
    {
        $targetReflection = $this->getReflection($sprykerDefinition);

        file_put_contents($targetReflection->getFileName(), $newContent);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return \Roave\BetterReflection\Reflection\Reflection|\Roave\BetterReflection\Reflection\ReflectionClass
     */
    protected function getReflection(SprykDefinitionInterface $sprykerDefinition)
    {
        $betterReflection = new BetterReflection();

        return $betterReflection->classReflector()->reflect($this->getTargetArgument($sprykerDefinition));
    }
}
