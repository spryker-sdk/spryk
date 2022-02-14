<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Module;

use Codeception\Module;
use Codeception\Stub;
use Codeception\Test\Unit;
use Codeception\TestInterface;
use org\bovigo\vfs\vfsStream;
use SprykerSdk\Spryk\Console\SprykRunConsole;
use SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\Dumper\ClassDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\FileDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SprykHelper extends Module
{
    /**
     * @var string|null
     */
    protected ?string $virtualDirectory = null;

    /**
     * @var array
     */
    protected $config = [
        'withTestSpryks' => false,
        'withTestTemplates' => false,
    ];

    /**
     * Always Mock the configuration
     *
     * @param \Codeception\TestInterface $test
     *
     * @return void
     */
    public function _before(TestInterface $test): void
    {
        parent::_before($test);

        $this->virtualDirectory = null;

        $container = $this->getContainer();
        $container->set(SprykConfig::class, $this->getSprykConfigMock());

        $this->getFileResolver()->reset();
    }

    /**
     * @param string $service
     * @param object $stubbedService
     *
     * @return void
     */
    public function setDependency(string $service, object $stubbedService): void
    {
        $this->getContainer()->set($service, $stubbedService);
    }

    /**
     * @param \Codeception\Test\Unit $testClass
     * @param array $arguments
     *
     * @return void
     */
    public function run(Unit $testClass, array $arguments): void
    {
        $sprykName = $this->getSprykName($testClass);

        /** @var \Codeception\Module\Symfony $symfony */
        $symfony = $this->getModule('Symfony');

        $command = $symfony->grabService(SprykRunConsole::class);

        $tester = $this->getConsoleTester($command, $sprykName);

        $arguments += [
            'command' => $command->getName(),
            SprykRunConsole::ARGUMENT_SPRYK => $sprykName,
        ];

        $arguments = $this->addDevelopmentModeFromConfig($arguments);

        $tester->execute($arguments, ['interactive' => false]);
    }

    /**
     * @param array $arguments
     *
     * @return array
     */
    protected function addDevelopmentModeFromConfig(array $arguments): array
    {
        if (isset($arguments['--mode'])) {
            return $arguments;
        }

        $arguments['--mode'] = 'core';

        return $arguments;
    }

    /**
     * @param \Codeception\Test\Unit $testClass
     *
     * @return string
     */
    protected function getSprykName(Unit $testClass): string
    {
        $classNameFragments = explode('\\', get_class($testClass));
        $classNameShort = array_pop($classNameFragments);
        $sprykName = substr($classNameShort, 0, -4);

        return $sprykName;
    }

    /**
     * @param \SprykerSdk\Spryk\Console\SprykRunConsole $command
     * @param string $sprykName
     *
     * @return \Symfony\Component\Console\Tester\CommandTester
     */
    public function getConsoleTester(SprykRunConsole $command, string $sprykName): CommandTester
    {
        $application = new Application();
        $application->add($command);

        $command = $application->find($command->getName());

        return new CommandTester($command);
    }

    /**
     * @return void
     */
    public function persistResolvedFiles(): void
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\FileDumperInterface $dumper */
        $dumper = $this->getClass(FileDumperInterface::class);
        $dumper->dumpFiles($this->getFileResolver()->all());

        foreach ($this->getFileResolver()->all() as $resolved) {
            file_put_contents($resolved->getFilePath(), $resolved->getContent());
        }
    }

    /**
     * @return \SprykerSdk\Spryk\SprykConfig|object
     */
    protected function getSprykConfigMock()
    {
        $sprykConfig = Stub::make(SprykConfig::class, [
            'getRootDirectory' => function () {
                // Write files only in memory
                return $this->getVirtualDirectory();
            },
            'getSprykDirectories' => function () {
                $sprykDirectories = [
                    $this->getRootDirectory() . 'config/spryk/spryks/', // When not found use this path (default)
                ];
                if ($this->config['withTestSpryks']) {
                    array_unshift($sprykDirectories, codecept_data_dir('config/spryk/spryks/')); // First look up test files in tests/_data
                }

                return $sprykDirectories;
            },
            'getRootSprykDirectories' => function () {
                return [$this->getRootDirectory() . 'config/spryk/'];
            },
            'getTemplateDirectories' => function () {
                $templateDirectories = [
                    $this->getRootDirectory() . 'config/spryk/templates/', // When not found use this path (default)
                ];
                if ($this->config['withTestTemplates']) {
                    array_unshift($templateDirectories, codecept_data_dir('config/spryk/templates/')); // First look up test files in tests/_data
                }

                return $templateDirectories;
            },
            'getCoreNamespaces' => function () {
                return ['Spryker'];
            },
            'getProjectNamespace' => function () {
                return 'Pyz';
            },
            'getProjectNamespaces' => function () {
                return ['Pyz'];
            },
        ]);

        return $sprykConfig;
    }

    /**
     * @return string
     */
    public function getVirtualDirectory(): string
    {
        if (!$this->virtualDirectory) {
            $vfs = vfsStream::setup('root');
            $this->virtualDirectory = $vfs->url() . DIRECTORY_SEPARATOR;
        }

        return $this->virtualDirectory;
    }

    /**
     * @return string
     */
    protected function getRootDirectory(): string
    {
        return realpath(__DIR__ . '/../../../') . DIRECTORY_SEPARATOR;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface
     */
    public function getFileResolver(): FileResolverInterface
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver */
        $fileResolver = $this->getContainer()->get(FileResolverInterface::class);

        return $fileResolver;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\Dumper\ClassDumperInterface
     */
    public function getClassDumper(): ClassDumperInterface
    {
        /** @var \SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\Dumper\ClassDumperInterface $classDumper */
        $classDumper = $this->getContainer()->get(ClassDumperInterface::class);

        return $classDumper;
    }

    /**
     * @param string $classOrInterfaceName
     *
     * @return object
     */
    public function getClass(string $classOrInterfaceName): object
    {
        return $this->getContainer()->get($classOrInterfaceName);
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer(): ContainerInterface
    {
        /** @var \Codeception\Module\Symfony $symfony */
        $symfony = $this->getModule('Symfony');

        return $symfony->_getContainer();
    }
}
