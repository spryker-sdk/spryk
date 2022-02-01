<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Dumper\Dumper;

class JsonDumper implements JsonDumperInterface
{
    /**
     * @param array<\SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedJsonInterface> $resolvedFiles
     *
     * @return void
     */
    public function dump(array $resolvedFiles): void
    {
        foreach ($resolvedFiles as $resolvedJsonFile) {
            $resolvedJsonFile->setContent((string)json_encode($resolvedJsonFile->getDecodedJson(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
        }
    }
}
