<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\CopyModule;

use SprykerSdk\Spryk\Exception\SprykException;
use SprykerSdk\Spryk\Model\Spryk\Builder\AbstractBuilder;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Filter\DasherizeFilter;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class CopyModuleSpryk extends AbstractBuilder
{
    /**
     * @var string
     */
    protected const ARGUMENT_SOURCE_PATH = 'sourcePath';

    /**
     * @var string
     */
    protected const ARGUMENT_TO_ORGANIZATION = 'toOrganization';

    /**
     * @var string
     */
    protected const ARGUMENT_TO_MODULE = 'toModule';

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Filter\DasherizeFilter
     */
    protected DasherizeFilter $dasherizeFilter;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     * @param \SprykerSdk\Spryk\Model\Spryk\Filter\DasherizeFilter $dasherizeFilter
     */
    public function __construct(SprykConfig $config, FileResolverInterface $fileResolver, DasherizeFilter $dasherizeFilter)
    {
        parent::__construct($config, $fileResolver);
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
     * @return bool
     */
    protected function shouldBuild(): bool
    {
        return true;
    }

    /**
     * @return void
     */
    protected function build(): void
    {
        $sourceFiles = $this->getSourceFiles();

        foreach ($sourceFiles as $sourceFile) {
            $this->copySourceFile($sourceFile);
        }
    }

    /**
     * @return \Symfony\Component\Finder\Finder|\Symfony\Component\Finder\SplFileInfo[]
     */
    protected function getSourceFiles(): Finder
    {
        $moduleName = $this->getModuleName();

        $sourcePaths = [
            $this->getSourcePath(),
            str_replace($moduleName, $moduleName . 'Extension', $this->getSourcePath()),
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
     * @return string
     */
    protected function getSourcePath(): string
    {
        return $this->getStringArgument(static::ARGUMENT_SOURCE_PATH);
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $fileInfo
     *
     * @return void
     */
    protected function copySourceFile(SplFileInfo $fileInfo): void
    {
        $targetPath = $this->buildTargetPath($fileInfo);

        if (!is_dir(dirname($targetPath))) {
            mkdir(dirname($targetPath), 0777, true);
        }

        $sourceFileContent = $fileInfo->getContents();
        $targetFileContent = $this->prepareTargetFileContent($sourceFileContent);

        file_put_contents($targetPath, $targetFileContent);

        $this->log(sprintf(
            'Copied "<fg=green>%s</>" to "<fg=green>%s</>"',
            rtrim($fileInfo->getRelativePath(), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileInfo->getFilename(),
            $targetPath,
        ));
    }

    /**
     * @param \Symfony\Component\Finder\SplFileInfo $fileInfo
     *
     * @return string
     */
    protected function buildTargetPath(SplFileInfo $fileInfo): string
    {
        $module = $this->getModuleName();

        $sourcePathRelative = ($fileInfo->getRelativePath() !== '') ? $fileInfo->getRelativePath() . DIRECTORY_SEPARATOR : '';
        $targetPath = $this->getTargetPath();

        if (strpos($fileInfo->getPathname(), sprintf('/%sExtension/', $module)) !== false) {
            $targetPath = rtrim($targetPath, DIRECTORY_SEPARATOR) . 'Extension' . DIRECTORY_SEPARATOR;
        }

        $fileName = $this->renameFile($fileInfo->getFilename());

        $searchAndReplaceMap = $this->buildSearchAndReplaceMapForFilePath();
        $targetPath .= str_replace(array_keys($searchAndReplaceMap), array_values($searchAndReplaceMap), $sourcePathRelative) . $fileName;

        return $targetPath;
    }

    /**
     * @param string $fileName
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykException
     *
     * @return string
     */
    protected function renameFile(string $fileName): string
    {
        $module = $this->getModuleName();
        $toModule = $this->getStringArgument(static::ARGUMENT_TO_MODULE);

        $searchAndReplace = [
            sprintf('/%sConfig.php/', $module) => sprintf('%sConfig.php', $toModule),
            sprintf('/%sConstants.php/', $module) => sprintf('%sConstants.php', $toModule),
            sprintf('/%sFacade.php/', $module) => sprintf('%sFacade.php', $toModule),
            sprintf('/%sFacadeInterface.php/', $module) => sprintf('%sFacadeInterface.php', $toModule),
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
     * @return array
     */
    protected function buildSearchAndReplaceMapForFilePath(): array
    {
        $organization = $this->getOrganizationName();
        $module = $this->getModuleName();

        $toOrganization = $this->getStringArgument(static::ARGUMENT_TO_ORGANIZATION);
        $toModule = $this->getStringArgument(static::ARGUMENT_TO_MODULE);

        return [
            sprintf('/%s/', $organization) => sprintf('/%s/', $toOrganization),
            sprintf('/%sTest/', $organization) => sprintf('/%sTest/', $toOrganization),
            sprintf('/%s/', $module) => sprintf('/%s/', $toModule),
            sprintf('/%sExtension/', $module) => sprintf('/%sExtension/', $toModule),
        ];
    }

    /**
     * @param string $content
     *
     * @throws \SprykerSdk\Spryk\Exception\SprykException
     *
     * @return string
     */
    protected function prepareTargetFileContent(string $content): string
    {
        $searchAndReplaceMap = $this->buildSearchAndReplaceMapForFileContent();

        $content = preg_replace(array_keys($searchAndReplaceMap), array_values($searchAndReplaceMap), $content);

        if ($content === null) {
            throw new SprykException('There was an error while replacing file content fragments.');
        }

        return $content;
    }

    /**
     * @return array
     */
    protected function buildSearchAndReplaceMapForFileContent(): array
    {
        $organization = $this->getOrganizationName();
        $organizationDashed = $this->dasherize($organization);

        $module = $this->getModuleName();
        $moduleDashed = $this->dasherize($module);

        $toOrganization = $this->getStringArgument(static::ARGUMENT_TO_ORGANIZATION);
        $toOrganizationDashed = $this->dasherize($toOrganization);

        $toModule = $this->getStringArgument(static::ARGUMENT_TO_MODULE);
        $toModuleDashed = $this->dasherize($toModule);

        return [
            sprintf('/%s\\\\(\w+)\\\\%s(?=[\\\\;])/', $organization, $module) => sprintf('%s\\\\${1}\\\\%s', $toOrganization, $toModule),
            sprintf('/%s\\\\(\w+)\\\\%sExtension(?=[\\\\;])/', $organization, $module) => sprintf('%s\\\\${1}\\\\%sExtension', $toOrganization, $toModule),
            sprintf('/%s\/%s(?=[\"\.\)\/\n])/', $organizationDashed, $moduleDashed) => sprintf('%s/%s', $toOrganizationDashed, $toModuleDashed),
            sprintf('/%s\/%s-extension(?=[\"\.\)\/\n])/', $organizationDashed, $moduleDashed) => sprintf('%s/%s-extension', $toOrganizationDashed, $toModuleDashed),
            sprintf('/"%s\\\\/', $organization) => sprintf('"%s\\', $toOrganization),
            sprintf('/"src\/%s/', $organization) => sprintf('"src/%s', $toOrganization),
            sprintf('/%s\s/', $module) => sprintf('%s ', $toModule),
            sprintf('/interface %s([A-Z]+)/', $module) => sprintf('interface %s${1}', $toModule),
            sprintf('/class %s([A-Z]+)/', $module) => sprintf('class %s${1}', $toModule),
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
     * @return string
     */
    protected function getTargetPath(): string
    {
        return $this->config->getRootDirectory() . $this->getStringArgument(static::ARGUMENT_TARGET_PATH);
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
