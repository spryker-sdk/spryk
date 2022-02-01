<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace _support\Fixtures\Dumper;

class UnorderedClass
{
    use DumperTrait;

    /**
     * @var string
     */
    public const PUBLIC_CONST = 'PUBLIC_CONST';
    /**
     * @var string
     */
    protected const PROTECTED_CONST = 'PROTECTED_CONST';
    /**
     * @var string
     */
    private const PRIVATE_CONST = 'PRIVATE_CONST';
    /**
     * @var string
     */
    public string $baz;
    /**
     * @var string
     */
    protected string $bar;
    /**
     * @var string
     */
    private string $foo;
    /**
     * @param string $foo
     */
    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
    /**
     * @return void
     */
    public function baz(): void
    {
    }
    /**
     * @return void
     */
    protected function bar(): void
    {
    }
    /**
     * @return void
     */
    private function foo(): void
    {
    }
}
