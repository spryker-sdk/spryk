<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template;

use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class TemplateSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET_PATH = 'targetPath';
    public const ARGUMENT_TARGET_FILE_NAME = 'targetFilename';
    public const ARGUMENT_TEMPLATE = 'template';

    public const ARGUMENT_MODE = 'mode';
    public const ARGUMENT_LAYER = 'layer';
    public const ARGUMENT_MODULE = 'module';
    public const ARGUMENT_OVERWRITE = 'overwrite';
    public const ARGUMENT_CORE_CLASS = 'coreClass';
    public const ARGUMENT_CORE_NAMESPACE = 'coreNamespace';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $renderer;

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @var array
     */
    protected $coreNamespaces;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $renderer
     * @param string $rootDirectory
     * @param array $coreNamespaces
     */
    public function __construct(
        TemplateRendererInterface $renderer,
        string $rootDirectory,
        array $coreNamespaces
    ) {
        $this->renderer = $renderer;
        $this->rootDirectory = $rootDirectory;
        $this->coreNamespaces = $coreNamespaces;
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

        $this->checkCoreExtensionToProjectLevel($sprykDefinition);

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

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     */
    protected function checkCoreExtensionToProjectLevel(SprykDefinitionInterface $sprykDefinition): void
    {
        if($sprykDefinition->getArgumentCollection()->getArgument(self::ARGUMENT_MODE)->getValue() === 'core') {
            return;
        }

        foreach ($this->coreNamespaces as $coreNamespace) {
            $coreClass = sprintf('%s\\%s\\%s\\%s',
                $coreNamespace,
                $sprykDefinition->getArgumentCollection()->getArgument(self::ARGUMENT_LAYER)->getValue(),
                $sprykDefinition->getArgumentCollection()->getArgument(self::ARGUMENT_MODULE)->getValue(),
                substr($sprykDefinition->getArgumentCollection()->getArgument(self::ARGUMENT_TARGET_FILE_NAME)->getValue(), 0, -4)
            );

            if (class_exists($coreClass) || interface_exists($coreClass)) {
                $argumentCollection = $sprykDefinition->getArgumentCollection();

                $methodArgument = (new Argument())
                    ->setName(self::ARGUMENT_OVERWRITE)
                    ->setValue(true);
                $argumentCollection->addArgument($methodArgument);

                $methodArgument = (new Argument())
                    ->setName(self::ARGUMENT_CORE_CLASS)
                    ->setValue($coreClass);
                $argumentCollection->addArgument($methodArgument);

                $methodArgument = (new Argument())
                    ->setName(self::ARGUMENT_CORE_NAMESPACE)
                    ->setValue($coreNamespace);
                $argumentCollection->addArgument($methodArgument);

                return;
            }
        }
    }
}
