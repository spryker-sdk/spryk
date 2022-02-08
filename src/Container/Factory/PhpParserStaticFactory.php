<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Container\Factory;

use PhpParser\Lexer;
use PhpParser\Parser;
use PhpParser\ParserFactory;

class PhpParserStaticFactory
{
    /**
     * @var \PhpParser\Lexer
     */
    protected Lexer $lexer;

    /**
     * @param \PhpParser\Lexer $lexer
     */
    public function __construct(Lexer $lexer)
    {
        $this->lexer = $lexer;
    }

    /**
     * @return \PhpParser\Parser
     */
    public function createParser(): Parser
    {
        return (new ParserFactory())->create(ParserFactory::PREFER_PHP7, $this->lexer);
    }
}
