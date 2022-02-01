<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver;

use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface;

interface FileResolverInterface
{
    /**
     * @param string $name
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface|null
     */
    public function resolve(string $name): ?ResolvedInterface;

    /**
     * @return iterable<string, \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface>
     */
    public function all(): iterable;

    /**
     * @param string $filePath
     * @param string $content
     *
     * @return void
     */
    public function addFile(string $filePath, string $content): void;

    /**
     * @return void
     */
    public function reset(): void;
}
