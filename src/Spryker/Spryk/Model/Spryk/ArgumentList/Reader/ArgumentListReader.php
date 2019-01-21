<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ArgumentList\Reader;

use Symfony\Component\Yaml\Yaml;

class ArgumentListReader implements ArgumentListReaderInterface
{
    /**
     * @var string
     */
    protected $argumentListFilePath;

    /**
     * @param string $argumentListFilePath
     */
    public function __construct(string $argumentListFilePath)
    {
        $this->argumentListFilePath = $argumentListFilePath;
    }

    /**
     * @return array
     */
    public function getCachedArgumentList(): array
    {
        $argumentList = Yaml::parseFile($this->argumentListFilePath);

        if ($argumentList === null) {
            return [];
        }

        return $argumentList;
    }
}
