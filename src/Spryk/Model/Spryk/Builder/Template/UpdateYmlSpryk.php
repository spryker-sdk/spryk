<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Template;

use SprykerSdk\Spryk\Exception\YmlException;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Yaml\Yaml;

class UpdateYmlSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    public const ARGUMENT_TEMPLATE = 'template';

    /**
     * @var string
     */
    public const ARGUMENT_AFTER_ELEMENT = 'afterElement';

    /**
     * @var string
     */
    public const ARGUMENT_ADD_TO_ELEMENT = 'addToElement';

    /**
     * @var string
     */
    public const ARGUMENT_CONTENT = 'content';

    /**
     * @var int
     */
    public const YAML_START_INLINE_LEVEL = 10;

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
        return 'update-yml';
    }

    /**
     * @throws \SprykerSdk\Spryk\Exception\YmlException
     *
     * @return void
     */
    protected function build(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedYmlInterface|null $resolved */
        $resolved = $this->fileResolver->resolve($this->getTargetPath());

        if (!$resolved || empty($resolved->getDecodedYml())) {
            throw new YmlException(sprintf('The YML file "%s" is empty or it was not able to parse it.', $this->getTargetPath()));
        }

        $targetYml = $this->prepareTargetYaml($resolved->getDecodedYml());
        $resolved->setDecodedYml($this->updateYaml($targetYml));

        $this->log(sprintf('Updated <fg=green>%s</>', $this->getTargetPath()));
    }

    /**
     * @param array $targetYaml
     *
     * @return array
     */
    protected function prepareTargetYaml(array $targetYaml): array
    {
        $addToElementPath = $this->getAddToElement();
        $afterElement = $this->getAfterElement();

        $currentLevel = &$targetYaml;
        foreach ($addToElementPath as $pathElement) {
            if (!array_key_exists($pathElement, $currentLevel)) {
                $newCurrentLevel = [];
                foreach ($currentLevel as $key => $value) {
                    $newCurrentLevel[$key] = $value;
                    if ($key === $afterElement) {
                        $newCurrentLevel[$pathElement] = [];
                    }
                }
                if (!array_key_exists($pathElement, $newCurrentLevel)) {
                    $newCurrentLevel[$pathElement] = [];
                }
                $currentLevel = $newCurrentLevel;
            }
            $currentLevel = &$currentLevel[$pathElement];
        }

        return $targetYaml;
    }

    /**
     * @return mixed
     */
    protected function getYamlToAdd()
    {
        if ($this->arguments->hasArgument(static::ARGUMENT_CONTENT)) {
            return $this->getStringArgument(static::ARGUMENT_CONTENT);
        }

        return $this->getDataForYml();
    }

    /**
     * @return array
     */
    protected function getDataForYml(): array
    {
        $content = $this->getContent($this->getTemplateName());
        $yaml = Yaml::parse($content);

        return $yaml;
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
        return $this->renderer->render(
            $templateName,
            $this->arguments->getArguments(),
        );
    }

    /**
     * @param array $targetYaml
     *
     * @return array
     */
    protected function updateYaml(array $targetYaml): array
    {
        $content = $this->getYamlToAdd();
        $addToElementPath = $this->getAddToElement();

        $currentLevel = &$targetYaml;
        foreach ($addToElementPath as $key) {
            $currentLevel = &$currentLevel[$key];
        }

        if (is_array($content)) {
            $currentLevel = array_merge($currentLevel, $content);

            return $targetYaml;
        }

        if (in_array($content, $currentLevel, true)) {
            return $targetYaml;
        }

        $currentLevel[] = $content;

        return $targetYaml;
    }

    /**
     * @return array
     */
    protected function getAddToElement(): array
    {
        return explode('.', $this->getStringArgument(static::ARGUMENT_ADD_TO_ELEMENT));
    }

    /**
     * @return string|null
     */
    protected function getAfterElement(): ?string
    {
        return $this->arguments->getArgument(static::ARGUMENT_AFTER_ELEMENT)->getValue();
    }
}
