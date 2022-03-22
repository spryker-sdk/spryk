<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk;

use PhpParser\Lexer;
use PhpParser\Lexer\Emulative;
use PhpParser\Parser;
use PhpParser\ParserFactory;
use PhpParser\PrettyPrinter\Standard;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface;
use SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface;
use SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class SprykFactory
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface
     */
    protected SprykExecutorInterface $executor;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface
     */
    protected SprykDefinitionDumperInterface $definitionDumper;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface
     */
    protected ArgumentListGeneratorInterface $argumentListGenerator;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface
     */
    protected ArgumentListReaderInterface $argumentListReader;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    protected SprykConfigurationLoaderInterface $configurationLoader;

    /**
     * @var \PhpParser\Lexer|null
     */
    protected ?Lexer $lexer = null;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface $executor
     * @param \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface $definitionDumper
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface $argumentListGenerator
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface $argumentListReader
     * @param \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface $configurationLoader
     */
    public function __construct(
        SprykConfig $config,
        SprykExecutorInterface $executor,
        SprykDefinitionDumperInterface $definitionDumper,
        ArgumentListGeneratorInterface $argumentListGenerator,
        ArgumentListReaderInterface $argumentListReader,
        SprykConfigurationLoaderInterface $configurationLoader
    ) {
        $this->config = $config;
        $this->executor = $executor;
        $this->definitionDumper = $definitionDumper;
        $this->argumentListGenerator = $argumentListGenerator;
        $this->argumentListReader = $argumentListReader;
        $this->configurationLoader = $configurationLoader;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Executor\SprykExecutorInterface
     */
    public function getExecutor(): SprykExecutorInterface
    {
        return $this->executor;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface
     */
    public function getDefinitionDumper(): SprykDefinitionDumperInterface
    {
        return $this->definitionDumper;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator\ArgumentListGeneratorInterface
     */
    public function getArgumentListGenerator(): ArgumentListGeneratorInterface
    {
        return $this->argumentListGenerator;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader\ArgumentListReaderInterface
     */
    public function getArgumentListReader(): ArgumentListReaderInterface
    {
        return $this->argumentListReader;
    }

    /**
     * @return \SprykerSdk\Spryk\Model\Spryk\Configuration\Loader\SprykConfigurationLoaderInterface
     */
    public function getConfigurationLoader(): SprykConfigurationLoaderInterface
    {
        return $this->configurationLoader;
    }

    /**
     * @return \PhpParser\PrettyPrinter\Standard
     */
    public function createClassPrinter(): Standard
    {
        return new Standard();
    }

    /**
     * @return \PhpParser\Parser
     */
    public function createParser(): Parser
    {
        return (new ParserFactory())->create(ParserFactory::PREFER_PHP7, $this->createLexer());
    }

    /**
     * @return \PhpParser\Lexer
     */
    public function createLexer(): Lexer
    {
        if (!$this->lexer) {
            $this->lexer = new Emulative([
                'usedAttributes' => [
                    'comments',
                    'startLine', 'endLine',
                    'startTokenPos', 'endTokenPos',
                ],
            ]);
        }

        return $this->lexer;
    }

    /**
     * @return \Symfony\Component\Cache\Adapter\AdapterInterface
     */
    public function createFilesystemCacheAdepter(): AdapterInterface
    {
        return new FilesystemAdapter();
    }
}
