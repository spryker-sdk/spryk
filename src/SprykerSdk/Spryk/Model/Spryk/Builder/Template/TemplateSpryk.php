<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template;

use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class TemplateSpryk implements SprykBuilderInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_TARGET_PATH = 'targetPath';
    /**
     * @var string
     */
    public const ARGUMENT_TARGET_FILE_NAME = 'targetFilename';
    /**
     * @var string
     */
    public const ARGUMENT_TEMPLATE = 'template';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
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
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        $targetPath = $this->getTargetPath($sprykDefinition);

        return (!file_exists($targetPath));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetPath = $this->getTargetPath($sprykDefinition);
        $templateName = $this->getTemplateName($sprykDefinition);

        $targetDirectory = dirname($targetPath);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
            $style->report(sprintf('Created <fg=green>%s</>', $targetDirectory));
        }

        $content = $this->getContent($sprykDefinition, $templateName);

        file_put_contents($targetPath, $content);

        $style->report(sprintf('Created <fg=green>%s</>', $targetPath));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykDefinition): string
    {
        $targetPath = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();

        $targetPath = rtrim($targetPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $fileName = $this->getFilename($sprykDefinition);
        $subDirectory = $this->getSubDirectory($sprykDefinition);

        return $this->rootDirectory . $targetPath . $subDirectory . $fileName;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getFilename(SprykDefinitionInterface $sprykDefinition): string
    {
        $filename = $this->getFilenameFromTemplateName($sprykDefinition);

        if ($sprykDefinition->getArgumentCollection()->hasArgument(static::ARGUMENT_TARGET_FILE_NAME)) {
            $filename = $sprykDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_TARGET_FILE_NAME)->getValue();
        }

        return $filename;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getSubDirectory(SprykDefinitionInterface $sprykDefinition): string
    {
        $subDirectory = '';
        if ($sprykDefinition->getArgumentCollection()->hasArgument('subDirectory') && $sprykDefinition->getArgumentCollection()->getArgument('subDirectory')->getValue() !== null) {
            $subDirectory = rtrim($sprykDefinition->getArgumentCollection()->getArgument('subDirectory')->getValue(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        return $subDirectory;
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
     * @param string $templateName
     *
     * @return string
     */
    protected function getContent(SprykDefinitionInterface $sprykDefinition, string $templateName): string
    {
        if (isset($sprykDefinition->getConfig()['noRender'])) {
            return $this->renderer->getSource($templateName);
        }

        return $this->renderer->render(
            $templateName,
            $sprykDefinition->getArgumentCollection()->getArguments()
        );
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getFilenameFromTemplateName(SprykDefinitionInterface $sprykDefinition): string
    {
        $filename = str_replace('.twig', '', $this->getTemplateName($sprykDefinition));
        if (strpos($filename, '/') !== false) {
            $filenameFragments = explode('/', $filename);
            $filename = (string)array_pop($filenameFragments);
        }

        return $filename;
    }
}
