<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Dumper;

interface FileDumperInterface
{
    /**
     * @param iterable<string, \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface> $resolvedFiles
     *
     * @return void
     */
    public function dumpFiles(iterable $resolvedFiles): void;
}
