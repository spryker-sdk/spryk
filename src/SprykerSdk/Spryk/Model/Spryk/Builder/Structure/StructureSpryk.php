<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Structure;

use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

class StructureSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_DIRECTORIES = 'directories';
    public const ARGUMENT_TARGET_PATH = 'targetPath';

    /**
     * @var string
     */
    protected $rootDirectory;

    /**
     * @param string $rootDirectory
     */
    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'structure';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        $shouldBuild = false;
        $directories = $this->getDirectoriesToCreate($sprykDefinition);

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                $shouldBuild = true;
            }
        }

        return $shouldBuild;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $directories = $this->getDirectoriesToCreate($sprykDefinition);

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
                $style->report(sprintf('Created <fg=green>%s</>', $directory));
            }
        }
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string[]
     */
    protected function getDirectoriesToCreate(SprykDefinitionInterface $sprykDefinition): array
    {
        $directories = [];
        $directoriesArgument = $sprykDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_DIRECTORIES);

        $moduleDirectory = $this->getBaseDirectory($sprykDefinition);
        foreach ($directoriesArgument->getValue() as $directory) {
            $directories[] = $this->rootDirectory . $moduleDirectory . $directory;
        }

        return $directories;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getBaseDirectory(SprykDefinitionInterface $sprykDefinition): string
    {
        $rootDirectory = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();

        $rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        return $rootDirectory;
    }
}
