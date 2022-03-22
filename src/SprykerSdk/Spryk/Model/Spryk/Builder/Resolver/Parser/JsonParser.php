<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Parser;

use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedJson;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedJsonInterface;

class JsonParser implements ParserInterface
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
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedJsonInterface
     */
    protected function fromFilePath(string $filePath): ResolvedJsonInterface
    {
        $resolved = $this->fromFileContent((string)file_get_contents($filePath));
        $resolved->setFilePath($filePath);

        return $resolved;
    }

    /**
     * @param string $fileContents
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedJsonInterface
     */
    protected function fromFileContent(string $fileContents): ResolvedJsonInterface
    {
        $resolved = new ResolvedJson();

        $resolved->setOriginalContent($fileContents);
        $resolved->setContent($fileContents);

        $decodedJson = json_decode($fileContents, true);

        $resolved->setDecodedJson($decodedJson);

        return $resolved;
    }
}
