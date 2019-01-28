<?php

/**
 * This file is part of the Spryker Suite.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator;

use SprykerSdk\Spryk\Exception\FileGenerationException;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface;
use Symfony\Component\Yaml\Yaml;

class ArgumentListGenerator implements ArgumentListGeneratorInterface
{
    /**
     * @var string
     */
    protected $argumentListFilePath;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface
     */
    protected $argumentListBuilder;

    /**
     * @param string $argumentListFilePath
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface $argumentListBuilder
     */
    public function __construct(
        string $argumentListFilePath,
        ArgumentListBuilderInterface $argumentListBuilder
    ) {
        $this->argumentListFilePath = $argumentListFilePath;
        $this->argumentListBuilder = $argumentListBuilder;
    }

    /**
     * @param array $sprykDefinitions
     *
     * @throws \SprykerSdk\Spryk\Exception\FileGenerationException
     *
     * @return int
     */
    public function generateArgumentList(array $sprykDefinitions): int
    {
        $sprykDefinitions = $this->argumentListBuilder->buildArgumentList($sprykDefinitions);

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
