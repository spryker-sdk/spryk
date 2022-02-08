<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template;

use Exception;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\SprykConfig;

class TemplateSpryk extends AbstractBuilder
{
 /**
  * @var string
  */
    public const ARGUMENT_TARGET_FILE_NAME = 'targetFilename';

    /**
     * @var string
     */
    public const ARGUMENT_TEMPLATE = 'template';

    /**
     * @var string
     */
    public const ARGUMENT_SUB_DIRECTORY = 'subDirectory';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected TemplateRendererInterface $renderer;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     */
    public function __construct(SprykConfig $config, FileResolverInterface $fileResolver, TemplateRendererInterface $renderer)
    {
        parent::__construct($config, $fileResolver);

        $this->renderer = $renderer;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'template';
    }

    /**
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        $resolved = $this->fileResolver->resolve($this->getTargetPath());

        if ($resolved === null) {
            return true;
        }

        return false;
    }

    /**
     * @throws \Exception
     *
     * @return void
     */
    protected function build(): void
    {
        $targetPath = $this->getTargetPath();

        if ($this->fileResolver->resolve($targetPath)) {
            throw new Exception(sprintf('Trying to add a file from template failed, because the file "%s" already exists', $targetPath));
        }

        $templateName = $this->getTemplateName();

        $targetDirectory = dirname($targetPath);

        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0777, true);
            $this->log(sprintf('Created <fg=green>%s</>', $targetDirectory));
        }

        $content = $this->getContent($templateName);

        $this->fileResolver->addFile($targetPath, $content);

        $this->log(sprintf('Created <fg=green>%s</>', $targetPath));
    }

    /**
     * @return string
     */
    protected function getTargetPath(): string
    {
        $targetPath = parent::getTargetPath();

        $targetPath = rtrim($targetPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        $fileName = $this->getFilename();
        $subDirectory = $this->getSubDirectory();

        return $targetPath . $subDirectory . $fileName;
    }

    /**
     * @return string
     */
    protected function getFilename(): string
    {
        if ($this->arguments->hasArgument(static::ARGUMENT_TARGET_FILE_NAME)) {
            return $this->getStringArgument(static::ARGUMENT_TARGET_FILE_NAME);
        }

        return $this->getFilenameFromTemplateName();
    }

    /**
     * @return string
     */
    protected function getSubDirectory(): string
    {
        if ($this->arguments->hasArgument(static::ARGUMENT_SUB_DIRECTORY) && $this->arguments->getArgument(static::ARGUMENT_SUB_DIRECTORY)->getValue() !== null) {
            return rtrim($this->getStringArgument(static::ARGUMENT_SUB_DIRECTORY), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        }

        return '';
    }

    /**
     * @return string
     */
    protected function getTemplateName(): string
    {
        return $this->getStringArgument(static::ARGUMENT_TEMPLATE);
    }

    /**
     * @param string $templateName
     *
     * @return string
     */
    protected function getContent(string $templateName): string
    {
        if (isset($this->definition->getConfig()['noRender'])) {
            return $this->renderer->getSource($templateName);
        }

        return $this->renderer->render(
            $templateName,
            $this->arguments->getArguments(),
        );
    }

    /**
     * @return string
     */
    protected function getFilenameFromTemplateName(): string
    {
        $filename = str_replace('.twig', '', $this->getTemplateName());
        if (strpos($filename, '/') !== false) {
            $filenameFragments = explode('/', $filename);
            $filename = array_pop($filenameFragments);
        }

        return $filename;
    }
}
