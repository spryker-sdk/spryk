<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\ArgumentList\Reader;

use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\Cache\ItemInterface;

class ArgumentListReader implements ArgumentListReaderInterface
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface
     */
    protected ArgumentListBuilderInterface $argumentListBuilder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface
     */
    protected SprykDefinitionDumperInterface $definitionDumper;

    /**
     * @var \Symfony\Component\Cache\Adapter\FilesystemAdapter
     */
    protected FilesystemAdapter $cache;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface $argumentListBuilder
     * @param \SprykerSdk\Spryk\Model\Spryk\Dumper\SprykDefinitionDumperInterface $definitionDumper
     * @param \Symfony\Component\Cache\Adapter\FilesystemAdapter $cache
     */
    public function __construct(
        SprykConfig $config,
        ArgumentListBuilderInterface $argumentListBuilder,
        SprykDefinitionDumperInterface $definitionDumper,
        FilesystemAdapter $cache
    ) {
        $this->config = $config;
        $this->argumentListBuilder = $argumentListBuilder;
        $this->definitionDumper = $definitionDumper;
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    public function getArgumentList(): array
    {
        return $this->cache->get('argument_list_cache', function (ItemInterface $item) {
            $item->expiresAfter(3600);

            $sprykDefinition = $this->definitionDumper->dump();

            return $this->argumentListBuilder->buildArgumentList($sprykDefinition);
        });
    }

    /**
     * @return array
     */
    protected function getCachedArgumentList(): array
    {
        $argumentList = Yaml::parseFile($this->config->getArgumentListFilePath());

        if ($argumentList === null) {
            return [];
        }

        return $argumentList;
    }
}
