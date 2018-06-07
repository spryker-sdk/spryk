<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template;

use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;

class TemplateSpryk implements SprykBuilderInterface
{
    const ARGUMENT_TARGET_PATH = 'targetPath';
    const ARGUMENT_TARGET_FILE_NAME = 'targetFilename';
    const ARGUMENT_TEMPLATE = 'template';

    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     * @param string $rootDirectory
     */
    public function __construct(TemplateRendererInterface $renderer, string $rootDirectory)
    {
        $this->renderer = $renderer;
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'template';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykerDefinition): bool
    {
        $targetPath = $this->getTargetPath($sprykerDefinition);

        return (!file_exists($targetPath));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykerDefinition, SprykStyleInterface $style): void
    {
        $targetPath = $this->getTargetPath($sprykerDefinition);
        $templateName = $this->getTemplateName($sprykerDefinition);

        $targetDirectory = dirname($targetPath);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
            $style->report(sprintf('Created <fg=green>%s</>', $targetDirectory));
        }

        $content = $this->getContent($sprykerDefinition, $templateName);

        file_put_contents($targetPath, $content);

        $style->report(sprintf('Created <fg=green>%s</>', $targetPath));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykerDefinition): string
    {
        $targetPath = $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();

        $targetPath = rtrim($targetPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $fileName = str_replace('.twig', '', $this->getTemplateName($sprykerDefinition));

        if ($sprykerDefinition->getArgumentCollection()->hasArgument(static::ARGUMENT_TARGET_FILE_NAME)) {
            $fileName = $sprykerDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_TARGET_FILE_NAME)->getValue();
        }

        $subDirectory = '';
        if ($sprykerDefinition->getArgumentCollection()->hasArgument('subDirectory')) {
            $subDirectory = $sprykerDefinition->getArgumentCollection()->getArgument('subDirectory')->getValue();
            if ($subDirectory) {
                $subDirectory = rtrim($subDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
            }
        }

        return $this->rootDirectory . $targetPath . $subDirectory . $fileName;
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
     * @param string $templateName
     *
     * @return string
     */
    protected function getContent(SprykDefinitionInterface $sprykerDefinition, string $templateName): string
    {
        if (isset($sprykerDefinition->getConfig()['noRender'])) {
            return $this->renderer->getSource($templateName);
        }

        return $this->renderer->render(
            $templateName,
            $sprykerDefinition->getArgumentCollection()->getArguments()
        );
    }
}
