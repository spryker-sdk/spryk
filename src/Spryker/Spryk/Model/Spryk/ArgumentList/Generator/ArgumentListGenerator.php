<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\ArgumentList\Generator;

use Spryker\Spryk\Exception\FileGenerationException;
use Symfony\Component\Yaml\Yaml;

class ArgumentListGenerator implements ArgumentListGeneratorInterface
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
     * @param array $sprykDefinitions
     *
     * @throws \Spryker\Spryk\Exception\FileGenerationException
     *
     * @return int
     */
    public function generateArgumentList(array $sprykDefinitions): int
    {
        $dataDump = Yaml::dump($sprykDefinitions, 2, 2);
        $dataDump = $this->getFileDescriptionComment() . $dataDump;

        $result = file_put_contents($this->argumentListFilePath, $dataDump);

        if ($result !== false) {
            return $result;
        }

        throw new FileGenerationException('File was not generated. Please check internal logs.');
    }

    /**
     * @return string
     */
    protected function getFileDescriptionComment(): string
    {
        return '###'
            . PHP_EOL
            . '# This file collected all spryks arguments and generated with spryk:build command.'
            . PHP_EOL
            . '###'
            . PHP_EOL;
    }
}
