<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Transfer;

use Laminas\Filter\FilterChain;
use Laminas\Filter\Word\DashToCamelCase;
use SimpleXMLElement;
use SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;

abstract class AbstractTransferSpryk implements SprykBuilderInterface
{
    /**
     * @var string
     */
    public const ARGUMENT_TARGET_PATH = 'targetPath';

    /**
     * @var string
     */
    public const ARGUMENT_NAME = 'name';

    /**
     * @var string
     */
    protected const SPRYK_NAME = 'implemented by derived classes';

    /**
     * @var string
     */
    protected string $rootDirectory;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface
     */
    protected FileResolverInterface $fileResolver;

    /**
     * @param string $rootDirectory
     * @param \SprykerSdk\Spryk\Model\Spryk\Builder\Resolver\FileResolverInterface $fileResolver
     */
    public function __construct(string $rootDirectory, FileResolverInterface $fileResolver)
    {
        $this->rootDirectory = $rootDirectory;
        $this->fileResolver = $fileResolver;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::SPRYK_NAME;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    abstract public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    abstract public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void;

    /**
     * @param \SimpleXMLElement $simpleXMLElement
     * @param string $transferName
     *
     * @return \SimpleXMLElement|null
     */
    protected function findTransferByName(SimpleXMLElement $simpleXMLElement, string $transferName): ?SimpleXMLElement
    {
        /** @var \SimpleXMLElement $transferXMLElement */
        foreach ($simpleXMLElement->children() as $transferXMLElement) {
            if ((string)$transferXMLElement['name'] === $transferName) {
                return $transferXMLElement;
            }
        }

        return null;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetPath(SprykDefinitionInterface $sprykDefinition): string
    {
        return $this->rootDirectory . $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET_PATH)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTransferName(SprykDefinitionInterface $sprykDefinition): string
    {
        $dashToCamelCaseFilter = $this->getDashToCamelCase();

        $transferName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_NAME)
            ->getValue();

        return $dashToCamelCaseFilter->filter($transferName);
    }

    /**
     * @return \Laminas\Filter\FilterChain
     */
    protected function getDashToCamelCase(): FilterChain
    {
        $filterChain = new FilterChain();
        $filterChain
            ->attach(new DashToCamelCase());

        return $filterChain;
    }
}
