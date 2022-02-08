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
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class SprykFactory
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @var \PhpParser\Lexer|null
     */
    protected ?Lexer $lexer = null;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     */
    public function __construct(SprykConfig $config)
    {
        $this->config = $config;
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
