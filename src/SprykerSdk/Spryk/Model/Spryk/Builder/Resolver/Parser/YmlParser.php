<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Parser;

use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedYml;
use Symfony\Component\Yaml\Yaml;

class YmlParser implements ParserInterface
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
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedYml
     */
    protected function fromFilePath(string $filePath): ResolvedYml
    {
        $resolved = new ResolvedYml();
        $resolved->setFilePath($filePath);

        $fileContents = file_get_contents($filePath);

        if (!$fileContents) {
            return $resolved;
        }

        $resolved->setOriginalContent($fileContents);
        $resolved->setContent($fileContents);

        $resolved->setDecodedYml(Yaml::parse($fileContents));

        return $resolved;
    }

    /**
     * @param string $fileContents
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\Resolved\ResolvedYml
     */
    protected function fromFileContent(string $fileContents): ResolvedYml
    {
        $resolved = new ResolvedYml();

        $resolved->setOriginalContent($fileContents);
        $resolved->setContent($fileContents);

        $resolved->setDecodedYml(Yaml::parse($fileContents));

        return $resolved;
    }
}
