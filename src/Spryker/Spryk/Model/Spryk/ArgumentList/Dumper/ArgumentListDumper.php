<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ArgumentList\Dumper;

use Symfony\Component\Yaml\Yaml;

class ArgumentListDumper implements ArgumentListDumperInterface
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
    public function dumpArgumentList(): array
    {
        if (!file_exists($this->argumentListFilePath)) {
            return [];
        }

        $argumentList = Yaml::parseFile($this->argumentListFilePath);

        if ($argumentList === null) {
            return [];
        }

        return $argumentList;
    }
}
