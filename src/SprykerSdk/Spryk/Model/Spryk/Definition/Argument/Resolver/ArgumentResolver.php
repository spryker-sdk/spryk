<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Resolver;

use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Console\Question\Question;

class ArgumentResolver implements ArgumentResolverInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $argumentCollection;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $resolvedArgumentCollection;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface
     */
    protected $superseder;

    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface
     */
    protected $callbackArgumentResolver;

    /**
     * @var \SprykerSdk\Spryk\Style\SprykStyleInterface
     */
    protected $style;

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface $superseder
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface $callbackArgumentResolver
     */
    public function __construct(
        ArgumentCollectionInterface $argumentCollection,
        SupersederInterface $superseder,
        CallbackArgumentResolverInterface $callbackArgumentResolver
    ) {
        $this->argumentCollection = $argumentCollection;
        $this->resolvedArgumentCollection = clone $argumentCollection;
        $this->superseder = $superseder;
        $this->callbackArgumentResolver = $callbackArgumentResolver;
    }

    /**
     * @param array $arguments
     * @param string $sprykName
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(array $arguments, string $sprykName, SprykStyleInterface $style): ArgumentCollectionInterface
    {
        $this->style = $style;
        $argumentCollection = clone $this->argumentCollection;

        foreach ($arguments as $argumentName => $argumentDefinition) {
            $argument = $this->resolveArgument($argumentName, $sprykName, (array)$argumentDefinition);
            $argumentCollection->addArgument($argument);
            $this->resolvedArgumentCollection->addArgument($argument);
        }

        $argumentCollection = $this->superseder->supersede($argumentCollection, $this->resolvedArgumentCollection);
        $argumentCollection = $this->callbackArgumentResolver->resolve($argumentCollection);

        return $argumentCollection;
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array $argumentDefinition
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument
     */
    protected function resolveArgument(string $argumentName, string $sprykName, array $argumentDefinition): Argument
    {
        $argument = new Argument();
        $argument->setName($argumentName);

        if (isset($argumentDefinition['callback'])) {
            $argument->setCallbacks((array)$argumentDefinition['callback']);
        }

        if (isset($argumentDefinition['callbackOnly'])) {
            if ($this->isValueKnownForArgument($argumentName, $argumentDefinition)) {
                $argument->setValue($this->getKnownValueForArgument($argumentName, $argumentDefinition));
            }

            return $argument;
        }

        $value = $this->getValueForArgument($argumentName, $sprykName, $argumentDefinition);
        $argument->setValue($value);

        return $argument;
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array $argumentDefinition
     *
     * @return mixed
     */
    protected function getValueForArgument(string $argumentName, string $sprykName, array $argumentDefinition)
    {
        if ($this->isValueKnownForArgument($argumentName, $argumentDefinition)) {
            return $this->getKnownValueForArgument($argumentName, $argumentDefinition);
        }

        $defaultValue = $this->getDefaultValue($argumentName, $argumentDefinition);

        $allowEmptyInput = (isset($argumentDefinition['isOptional']) && ($argumentDefinition['isOptional'] === true)) ? true : false;

        return $this->askForArgumentValue($argumentName, $sprykName, $defaultValue, $allowEmptyInput);
    }

    /**
     * @param string $argumentName
     * @param array $argumentDefinition
     *
     * @return bool
     */
    protected function isValueKnownForArgument(string $argumentName, array $argumentDefinition): bool
    {
        if (isset($argumentDefinition['value']) || $this->canInherit($argumentName, $argumentDefinition) || OptionsContainer::hasOption($argumentName)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $argumentName
     * @param array $argumentDefinition
     *
     * @return bool
     */
    protected function canInherit(string $argumentName, array $argumentDefinition): bool
    {
        return (isset($argumentDefinition['inherit']) && $this->resolvedArgumentCollection->hasArgument($argumentName));
    }

    /**
     * @param string $argumentName
     * @param array $argumentDefinition
     *
     * @return mixed
     */
    protected function getKnownValueForArgument(string $argumentName, array $argumentDefinition)
    {
        if (isset($argumentDefinition['value']) && !$this->issetNonEmptyOption($argumentName)) {
            return $argumentDefinition['value'];
        }

        if ($this->canInherit($argumentName, $argumentDefinition)) {
            return $this->resolvedArgumentCollection->getArgument($argumentName)->getValue();
        }

        return OptionsContainer::getOption($argumentName);
    }

    /**
     * @param string $argumentName
     *
     * @return bool
     */
    protected function issetNonEmptyOption(string $argumentName): bool
    {
        if (!OptionsContainer::hasOption($argumentName)) {
            return false;
        }

        $optionValue = OptionsContainer::getOption($argumentName);

        if ($optionValue === '' || (is_array($optionValue) && count($optionValue) === 0)) {
            return false;
        }

        return true;
    }

    /**
     * @param string $argumentName
     * @param array|null $argumentDefinition
     *
     * @return mixed|null
     */
    protected function getDefaultValue(string $argumentName, ?array $argumentDefinition = null)
    {
        if (isset($argumentDefinition['default'])) {
            return $argumentDefinition['default'];
        }

        if ($this->resolvedArgumentCollection->hasArgument($argumentName)) {
            $argumentValue = $this->resolvedArgumentCollection->getArgument($argumentName)->getValue();
            if (!is_array($argumentValue)) {
                return $argumentValue;
            }
        }

        return null;
    }

    /**
     * @param string $argument
     * @param string $sprykName
     * @param string|int|null $default
     * @param bool $allowEmpty
     *
     * @return string|int|null
     */
    protected function askForArgumentValue(string $argument, string $sprykName, $default, bool $allowEmpty = false)
    {
        $question = new Question(sprintf('Enter value for <fg=yellow>%s.%s</> argument', $sprykName, $argument), $default);

        if ($allowEmpty === true) {
            $question->setValidator(function ($value) {
                if ($value === null) {
                    return '';
                }

                return $value;
            });
        }

        return $this->style->askQuestion($question);
    }
}
