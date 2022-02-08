<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\ArgumentList\Generator;

use SprykerSdk\Spryk\Exception\FileGenerationException;
use SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface;
use SprykerSdk\Spryk\SprykConfig;
use Symfony\Component\Yaml\Yaml;

class ArgumentListGenerator implements ArgumentListGeneratorInterface
{
    /**
     * @var \SprykerSdk\Spryk\SprykConfig
     */
    protected SprykConfig $config;

    /**
     * @var string
     */
    protected $argumentListFilePath;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface
     */
    protected $argumentListBuilder;

    /**
     * @param \SprykerSdk\Spryk\SprykConfig $config
     * @param \SprykerSdk\Spryk\Model\Spryk\ArgumentList\Builder\ArgumentListBuilderInterface $argumentListBuilder
     */
    public function __construct(
        SprykConfig $config,
        ArgumentListBuilderInterface $argumentListBuilder
    ) {
        $this->config = $config;
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

        $result = file_put_contents($this->config->getArgumentListFilePath(), $dataDump);

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
