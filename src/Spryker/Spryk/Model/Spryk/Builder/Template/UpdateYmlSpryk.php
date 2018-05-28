<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Template;

use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use Symfony\Component\Yaml\Yaml;

class UpdateYmlSpryk implements SprykBuilderInterface
{
    const ARGUMENT_TARGET_PATH = 'targetPath';
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
    const ARGUMENT_ADD_TO_ELEMENT = 'addToElement';

    const ARGUMENT_AFTER_ELEMENT = 'after';

    const ARGUMENT_CONTENT = 'content';

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
        return 'update-yml';
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykerDefinition): bool
    {
        return true;
        $targetPath = $this->getTargetPath($sprykerDefinition);

        return (!file_exists($targetPath));
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykerDefinition): void
    {
        $targetYaml = $this->getTargetYamlAsArray($sprykerDefinition);
        $addToElement = $sprykerDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_ADD_TO_ELEMENT)->getValue();
        $afterElement = $sprykerDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_AFTER_ELEMENT)->getValue();
        $newTargetYaml = [];

        if (!isset($targetYaml[$addToElement])) {
            foreach ($targetYaml as $key => $value) {
                $newTargetYaml[$key] = $value;
                if ($key === $afterElement) {
                    $newTargetYaml[$addToElement] = [];
                }
            }
        }

        $targetYaml = $newTargetYaml;

        $content = $afterElement = $sprykerDefinition->getArgumentCollection()->getArgument(self::ARGUMENT_CONTENT)->getValue();
        $targetYaml[$addToElement][] = $content;

        $yamlContent = Yaml::dump($targetYaml);

        file_put_contents($this->getTargetPath($sprykerDefinition), $yamlContent);
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

        return $this->rootDirectory . $targetPath;
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

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return array
     */
    protected function getTargetYamlAsArray(SprykDefinitionInterface $sprykerDefinition): array
    {
        $targetPath = $this->getTargetPath($sprykerDefinition);
        $yaml = Yaml::parse(file_get_contents($targetPath));

        return $yaml;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return array
     */
    protected function getSourceYamlAsArray(SprykDefinitionInterface $sprykerDefinition): string
    {
        $targetPath = $this->getTargetPath($sprykerDefinition);
        $yaml = Yaml::parse(file_get_contents($targetPath));

        return $yaml;
    }
}
