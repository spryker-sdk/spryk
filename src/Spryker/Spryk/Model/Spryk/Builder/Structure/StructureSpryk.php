<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Builder\Structure;

use Spryker\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;

class StructureSpryk implements SprykBuilderInterface
{
    protected const ARGUMENT_DIRECTORIES = 'directories';
    protected const ARGUMENT_TARGET_PATH = 'targetPath';

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
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykerDefinition): bool
    {
        $shouldBuild = false;
        $directories = $this->getDirectoriesToCreate($sprykerDefinition);

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                $shouldBuild = true;
            }
        }

        return $shouldBuild;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykerDefinition): void
    {
        $directories = $this->getDirectoriesToCreate($sprykerDefinition);

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
        }
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string[]
     */
    protected function getDirectoriesToCreate(SprykDefinitionInterface $sprykerDefinition): array
    {
        $directories = [];
        $directoriesArgument = $sprykerDefinition->getArgumentCollection()->getArgument(static::ARGUMENT_DIRECTORIES);

        $moduleDirectory = $this->getBaseDirectory($sprykerDefinition);
        foreach ($directoriesArgument->getValue() as $directory) {
            $directories[] = $this->rootDirectory . DIRECTORY_SEPARATOR . $moduleDirectory . $directory;
        }

        return $directories;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykerDefinition
     *
     * @return string
     */
    protected function getBaseDirectory(SprykDefinitionInterface $sprykerDefinition): string
    {
        $rootDirectory = $sprykerDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();

        $rootDirectory = rtrim($rootDirectory, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;

        return $rootDirectory;
    }
}
