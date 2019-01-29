<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Builder\Constant;

use Roave\BetterReflection\BetterReflection;
use Roave\BetterReflection\Reflection\ReflectionClass;
use SprykerSdk\Spryk\Exception\EmptyFileException;
use SprykerSdk\Spryk\Exception\ReflectionException;
use SprykerSdk\Spryk\Model\Spryk\Builder\SprykBuilderInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Zend\Filter\FilterChain;
use Zend\Filter\StringToUpper;
use Zend\Filter\Word\CamelCaseToUnderscore;

class ConstantSpryk implements SprykBuilderInterface
{
    public const ARGUMENT_TARGET = 'target';
    public const ARGUMENT_CONSTANT_NAME = 'name';
    public const ARGUMENT_CONSTANT_VALUE = 'value';
    public const ARGUMENT_CONSTANT_VISIBILITY = 'visibility';

    /**
     * @return string
     */
    public function getName(): string
    {
        return 'constant';
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    public function shouldBuild(SprykDefinitionInterface $sprykDefinition): bool
    {
        return (!$this->constantExists($sprykDefinition));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return void
     */
    public function build(SprykDefinitionInterface $sprykDefinition, SprykStyleInterface $style): void
    {
        $targetFileContent = $this->getTargetFileContent($sprykDefinition);

        $search = '{';
        $positionOfOpeningBrace = strpos($targetFileContent, $search);

        $constantLine = sprintf(
            PHP_EOL . '    %s const %s = \'%s\';' . PHP_EOL,
            $this->getConstantVisibility($sprykDefinition),
            $this->getConstantName($sprykDefinition),
            $this->getConstantValue($sprykDefinition)
        );

        if ($positionOfOpeningBrace !== false) {
            $targetFileContent = substr_replace($targetFileContent, $constantLine, $positionOfOpeningBrace + 1, strlen($search));
        }

        $this->putTargetFileContent($sprykDefinition, $targetFileContent);

        $style->report(sprintf(
            'Added constant "<fg=green>%s</>" to "<fg=green>%s</>"',
            trim($constantLine),
            $sprykDefinition->getArgumentCollection()->getArgument('target')
        ));
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return bool
     */
    protected function constantExists(SprykDefinitionInterface $sprykDefinition): bool
    {
        $targetFileContent = $this->getTargetFileContent($sprykDefinition);
        $constant = sprintf('const %s', $this->getConstantName($sprykDefinition));

        return (strpos($targetFileContent, $constant) !== false);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getTargetArgument(SprykDefinitionInterface $sprykDefinition): string
    {
        return $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_TARGET)
            ->getValue();
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getConstantVisibility(SprykDefinitionInterface $sprykDefinition): string
    {
        $constantVisibility = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_VISIBILITY)
            ->getValue();

        return $constantVisibility;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getConstantName(SprykDefinitionInterface $sprykDefinition): string
    {
        $constantName = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_NAME)
            ->getValue();

        $filterChain = new FilterChain();
        $filterChain
            ->attach(new CamelCaseToUnderscore())
            ->attach(new StringToUpper());

        return $filterChain->filter($constantName);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string
     */
    protected function getConstantValue(SprykDefinitionInterface $sprykDefinition): string
    {
        $constantValue = $sprykDefinition
            ->getArgumentCollection()
            ->getArgument(static::ARGUMENT_CONSTANT_VALUE)
            ->getValue();

        return $constantValue;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\EmptyFileException
     *
     * @return string
     */
    protected function getTargetFileContent(SprykDefinitionInterface $sprykDefinition): string
    {
        $targetFileName = $this->getTargetFileName($sprykDefinition);

        $targetFileContent = file_get_contents($targetFileName);
        if ($targetFileContent === false || strlen($targetFileContent) === 0) {
            throw new EmptyFileException(sprintf('Target file "%s" seems to be empty', $targetFileName));
        }

        return $targetFileContent;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @throws \SprykerSdk\Spryk\Exception\ReflectionException
     *
     * @return string
     */
    protected function getTargetFileName(SprykDefinitionInterface $sprykDefinition): string
    {
        $targetFilename = $this->getTargetFileNameFromReflectionClass($sprykDefinition);

        if ($targetFilename === null) {
            throw new ReflectionException('Filename is not expected to be null!');
        }

        return $targetFilename;
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     * @param string $newContent
     *
     * @return void
     */
    protected function putTargetFileContent(SprykDefinitionInterface $sprykDefinition, string $newContent): void
    {
        $targetFilename = $this->getTargetFileName($sprykDefinition);

        file_put_contents($targetFilename, $newContent);
    }

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return \Roave\BetterReflection\Reflection\ReflectionClass|\Roave\BetterReflection\Reflection\Reflection
     */
    protected function getReflection(SprykDefinitionInterface $sprykDefinition)
    {
        $betterReflection = new BetterReflection();

        return $betterReflection->classReflector()->reflect($this->getTargetArgument($sprykDefinition));
    }

    /**
     * @codeCoverageIgnore
     *
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\SprykDefinitionInterface $sprykDefinition
     *
     * @return string|null
     */
    protected function getTargetFileNameFromReflectionClass(SprykDefinitionInterface $sprykDefinition)
    {
        $targetReflection = $this->getReflection($sprykDefinition);
        if (!($targetReflection instanceof ReflectionClass)) {
            return null;
        }

        return $targetReflection->getFileName();
    }
}
