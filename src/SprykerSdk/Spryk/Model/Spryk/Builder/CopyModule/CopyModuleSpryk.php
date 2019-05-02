<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\CopyModule;

use SprykerSdk\Spryk\Exception\SprykException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface;
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class CopyModuleSpryk implements SprykBuilderInterface
{
    protected const ARGUMENT_SOURCE_PATH = 'sourcePath';
    protected const ARGUMENT_ORGANIZATION = 'organization';
    protected const ARGUMENT_MODULE = 'module';

    protected const ARGUMENT_TARGET_PATH = 'targetFilePath';
    protected const ARGUMENT_TO_ORGANIZATION = 'toOrganization';
    protected const ARGUMENT_TO_MODULE = 'toModule';

    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected $config;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface
     */
    protected $dasherizeFilter;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Filter\FilterInterface $dasherizeFilter
     */
    public function __construct(SprykConfig $config, FilterInterface $dasherizeFilter)
    {
        $this->config = $config;
        $this->dasherizeFilter = $dasherizeFilter;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'copyModule';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return true;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $sourceFiles = $this->getSourceFiles($sprykDefinition);
        foreach ($sourceFiles as $sourceFile) {
            $this->copySourceFile($sourceFile, $sprykDefinition, $style);
        }
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \Symfony\Component\Finder\Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    protected function getSourceFiles(SprykDefinitionInterface $sprykDefinition): Finder
    {
        $moduleName = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE);

        $sourcePaths = [
            $this->getSourcePath($sprykDefinition),
            str_replace($moduleName, $moduleName . 'Extension', $this->getSourcePath($sprykDefinition)),
        ];

        $sourcePaths = array_filter($sourcePaths, 'glob');

        $finder = new Finder();
        $finder
            ->files()
            ->in($sourcePaths)
            ->ignoreDotFiles(false)
            ->exclude('tests/_output');

        return $finder;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getSourcePath(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_SOURCE_PATH);
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $fileInfo
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    protected function copySourceFile(SplFileInfo $fileInfo, SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetPath = $this->buildTargetPath($fileInfo, $sprykDefinition);

        if (!is_dir(dirname($targetPath))) {
            mkdir(dirname($targetPath), 0777, true);
        }

        $sourceFileContent = $fileInfo->getContents();
        $targetFileContent = $this->prepareTargetFileContent($sourceFileContent, $sprykDefinition);

        file_put_contents($targetPath, $targetFileContent);

        $style->report(sprintf(
            'Copied "<fg=green>%s</>" to "<fg=green>%s</>"',
            rtrim($fileInfo->getRelativePath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileInfo->getFilename(),
            $targetPath
        ));
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $fileInfo
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function buildTargetPath(SplFileInfo $fileInfo, SprykDefinitionInterface $sprykDefinition): string
    {
        $module = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE);

        $sourcePathRelative = ($fileInfo->getRelativePath() !== '') ? $fileInfo->getRelativePath() . DIRECTORY_SEPARATOR : '';
        $targetPath = $this->getTargetPath($sprykDefinition);

        if (strpos($fileInfo->getPathname(), sprintf('/%sExtension/', $module)) !== false) {
            $targetPath = rtrim($targetPath, DIRECTORY_SEPARATOR) . 'Extension' . DIRECTORY_SEPARATOR;
        }

        $fileName = $this->renameFile($fileInfo->getFilename(), $sprykDefinition);

        $searchAndReplaceMap = $this->buildSearchAndReplaceMapForFilePath($sprykDefinition);
        $targetPath .= str_replace(array_keys($searchAndReplaceMap), array_values($searchAndReplaceMap), $sourcePathRelative) . $fileName;

        return $targetPath;
    }

    /**
     * @param string $fileName
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykException
     *
     * @return string
     */
    protected function renameFile(string $fileName, SprykDefinitionInterface $sprykDefinition): string
    {
        $module = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE);
        $toModule = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TO_MODULE);

        $searchAndReplace = [
            sprintf('/%sConfig.php/', $module) => sprintf('%sConfig.php', $toModule),
            sprintf('/%sConstants.php/', $module) => sprintf('%sConstants.php', $toModule),
            sprintf('/%sFacade.php/', $module) => sprintf('%sFacade.php', $toModule),
            sprintf('/%sFactory.php/', $module) => sprintf('%sFactory.php', $toModule),
            sprintf('/%sCommunicationFactory.php/', $module) => sprintf('%sCommunicationFactory.php', $toModule),
            sprintf('/%sBusinessFactory.php/', $module) => sprintf('%sBusinessFactory.php', $toModule),
            sprintf('/%sPersistenceFactory.php/', $module) => sprintf('%sPersistenceFactory.php', $toModule),
            sprintf('/%sDependencyProvider.php/', $module) => sprintf('%sDependencyProvider.php', $toModule),
            sprintf('/%s(\w+)TesterActions.php/', $module) => sprintf('%s${1}TesterActions.php', $toModule),
            sprintf('/%s(\w+)Tester.php/', $module) => sprintf('%s${1}Tester.php', $toModule),
        ];

        $fileName = preg_replace(array_keys($searchAndReplace), array_values($searchAndReplace), $fileName);
        if ($fileName === null) {
            throw new SprykException('There was an error while replacing file name fragments.');
        }

        return $fileName;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function buildSearchAndReplaceMapForFilePath(SprykDefinitionInterface $sprykDefinition): array
    {
        $organization = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_ORGANIZATION);
        $module = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE);

        $toOrganization = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TO_ORGANIZATION);
        $toModule = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TO_MODULE);

        return [
            sprintf('/%s/', $organization) => sprintf('/%s/', $toOrganization),
            sprintf('/%sTest/', $organization) => sprintf('/%sTest/', $toOrganization),
            sprintf('/%s/', $module) => sprintf('/%s/', $toModule),
            sprintf('/%sExtension/', $module) => sprintf('/%sExtension/', $toModule),
        ];
    }

    /**
     * @param string $content
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykException
     *
     * @return string
     */
    protected function prepareTargetFileContent(string $content, SprykDefinitionInterface $sprykDefinition): string
    {
        $searchAndReplaceMap = $this->buildSearchAndReplaceMapForFileContent($sprykDefinition);

        $content = preg_replace(array_keys($searchAndReplaceMap), array_values($searchAndReplaceMap), $content);

        if ($content === null) {
            throw new SprykException('There was an error while replacing file content fragments.');
        }

        return $content;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return array
     */
    protected function buildSearchAndReplaceMapForFileContent(SprykDefinitionInterface $sprykDefinition): array
    {
        $organization = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_ORGANIZATION);
        $organizationDashed = $this->dasherize($this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_ORGANIZATION));
        $module = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE);
        $moduleDashed = $this->dasherize($this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE));

        $toOrganization = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TO_ORGANIZATION);
        $toOrganizationDashed = $this->dasherize($this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TO_ORGANIZATION));
        $toModule = $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TO_MODULE);
        $toModuleDashed = $this->dasherize($this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_MODULE));

        return [
            sprintf('/%s\\\\(\w+)\\\\%s(?=[\\\\;])/', $organization, $module) => sprintf('%s\\\\${1}\\\\%s', $toOrganization, $toModule),
            sprintf('/%s\\\\(\w+)\\\\%sExtension(?=[\\\\;])/', $organization, $module) => sprintf('%s\\\\${1}\\\\%sExtension', $toOrganization, $toModule),
            sprintf('/%s\/%s(?=[\"\.\)\/\n])/', $organizationDashed, $moduleDashed) => sprintf('%s/%s', $toOrganizationDashed, $toModuleDashed),
            sprintf('/%s\/%s-extension(?=[\"\.\)\/\n])/', $organizationDashed, $moduleDashed) => sprintf('%s/%s-extension', $toOrganizationDashed, $toModuleDashed),
            sprintf('/"%s\\\\/', $organization) => sprintf('"%s\\', $toOrganization),
            sprintf('/"src\/%s/', $organization) => sprintf('"src/%s', $toOrganization),
            sprintf('/%s\s/', $module) => sprintf('%s ', $toModule),
            sprintf('/%sExtension\s/', $module) => sprintf('%sExtension ', $toModule),
            sprintf('/%sConfig.php/', $module) => sprintf('%sConfig.php', $toModule),
            sprintf('/%sConstants.php/', $module) => sprintf('%sConstants.php', $toModule),
            sprintf('/%sFacade.php/', $module) => sprintf('%sFacade.php', $toModule),
            sprintf('/%sFactory.php/', $module) => sprintf('%sFactory.php', $toModule),
            sprintf('/%sCommunicationFactory.php/', $module) => sprintf('%sCommunicationFactory.php', $toModule),
            sprintf('/%sBusinessFactory.php/', $module) => sprintf('%sBusinessFactory.php', $toModule),
            sprintf('/%sPersistenceFactory.php/', $module) => sprintf('%sPersistenceFactory.php', $toModule),
            sprintf('/%sDependencyProvider.php/', $module) => sprintf('%sDependencyProvider.php', $toModule),
            sprintf('/%s(\w+)TesterActions.php/', $module) => sprintf('%s${1}TesterActions.php', $toModule),
            sprintf('/%s(\w+)Tester.php/', $module) => sprintf('%s${1}Tester.php', $toModule),
        ];
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->config->getRootDirectory() . $this->getArgumentValueByName($sprykDefinition, static::ARGUMENT_TARGET_PATH);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param string $argumentName
     *
     * @return string
     */
    protected function getArgumentValueByName(SprykDefinitionInterface $sprykDefinition, string $argumentName): string
    {
        $constantValue = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument($argumentName)
            ->getValue();

        return $constantValue;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    protected function dasherize(string $string): string
    {
        return $this->dasherizeFilter->filter($string);
    }
}
