<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Parser;

use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedFile;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface;

class FileParser implements ParserInterface
{
    /**
     * @param string $type
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface
     */
    public function parse(string $type): ResolvedInterface
    {
        if (is_file($type)) {
            return $this->fromFilePath($type);
        }

        return $this->fromFileContent($type);
    }

    /**
     * @param string $filePath
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedFile
     */
    protected function fromFilePath(string $filePath): ResolvedFile
    {
        $resolved = new ResolvedFile();
        $resolved->setFilePath($filePath);

        $fileContents = file_get_contents($filePath);

        if (!$fileContents) {
            return $resolved;
        }

        $resolved->setOriginalContent($fileContents);
        $resolved->setContent($fileContents);

        return $resolved;
    }

    /**
     * @param string $fileContents
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedFile
     */
    protected function fromFileContent(string $fileContents): ResolvedFile
    {
        $resolved = new ResolvedFile();

        $resolved->setOriginalContent($fileContents);
        $resolved->setContent($fileContents);

        return $resolved;
    }
}
