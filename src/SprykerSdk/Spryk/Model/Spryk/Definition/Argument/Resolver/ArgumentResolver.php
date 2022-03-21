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
use SprykerSdk\Spryk\SprykConfig;
use SprykerSdk\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class ArgumentResolver implements ArgumentResolverInterface
{
    /**
     * @var \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $argumentCollection;

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
        $this->superseder = $superseder;
        $this->callbackArgumentResolver = $callbackArgumentResolver;
    }

    /**
     * @param array $arguments
     * @param string $sprykName
     * @param \SprykerSdk\Spryk\Style\SprykStyleInterface $style
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface|null $resolvedArgumentCollection
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(
        array $arguments,
        string $sprykName,
        SprykStyleInterface $style,
        ?ArgumentCollectionInterface $resolvedArgumentCollection = null
    ): ArgumentCollectionInterface {
        $this->style = $style;
        $argumentCollection = clone $this->argumentCollection;

        if (!$resolvedArgumentCollection) {
            $resolvedArgumentCollection = clone $argumentCollection;
        }

        foreach ($arguments as $argumentName => $argumentDefinition) {
            $argument = $this->resolveArgument(
                $argumentName,
                $sprykName,
                (array)$argumentDefinition,
                $resolvedArgumentCollection,
            );
            $argumentCollection->addArgument($argument);
            $resolvedArgumentCollection->addArgument($argument);
        }

        $argumentCollection = $this->superseder->supersede($argumentCollection, $resolvedArgumentCollection);

        return $this->callbackArgumentResolver->resolve($argumentCollection);
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array $argumentDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArgumentCollection
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Argument
     */
    protected function resolveArgument(
        string $argumentName,
        string $sprykName,
        array $argumentDefinition,
        ArgumentCollectionInterface $resolvedArgumentCollection
    ): Argument {
        $argument = new Argument();
        $argument->setName($argumentName);

        $argument->setAllowOverride($argumentDefinition['allowOverride'] ?? false);

        if (isset($argumentDefinition['callback'])) {
            $argument->setCallbacks((array)$argumentDefinition['callback']);
        }

        if (isset($argumentDefinition['callbackOnly'])) {
            if ($this->isValueKnownForArgument($argumentName, $argumentDefinition, $resolvedArgumentCollection)) {
                $argument->setValue(
                    $this->getKnownValueForArgument($argumentName, $argumentDefinition, $resolvedArgumentCollection),
                );
            }

            return $argument;
        }

        $value = $this->getValueForArgument($argumentName, $sprykName, $argumentDefinition, $resolvedArgumentCollection);
        $argument->setValue($value);

        return $argument;
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array $argumentDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArgumentCollection
     *
     * @return mixed
     */
    protected function getValueForArgument(
        string $argumentName,
        string $sprykName,
        array $argumentDefinition,
        ArgumentCollectionInterface $resolvedArgumentCollection
    ) {
        if ($this->isValueKnownForArgument($argumentName, $argumentDefinition, $resolvedArgumentCollection)) {
            return $this->getKnownValueForArgument($argumentName, $argumentDefinition, $resolvedArgumentCollection);
        }

        $defaultValue = $this->getDefaultValue($argumentName, $argumentDefinition, $resolvedArgumentCollection);

        $allowEmptyInput = (isset($argumentDefinition['isOptional']) && ($argumentDefinition['isOptional'] === true)) ? true : false;

        if (
            !$allowEmptyInput
            && isset($argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUES])
            && is_array($argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUES])
        ) {
            return $this->choseArgumentValue($argumentName, $sprykName, $argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUES], $defaultValue);
        }

        return $this->askForArgumentValue($argumentName, $sprykName, $defaultValue, $allowEmptyInput);
    }

    /**
     * @param string $argumentName
     * @param array $argumentDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArgumentCollection
     *
     * @return bool
     */
    protected function isValueKnownForArgument(
        string $argumentName,
        array $argumentDefinition,
        ArgumentCollectionInterface $resolvedArgumentCollection
    ): bool {
        if (
            isset($argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUE])
            || $this->canInherit($argumentName, $argumentDefinition, $resolvedArgumentCollection)
            || OptionsContainer::hasOption($argumentName)
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param string $argumentName
     * @param array $argumentDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArgumentCollection
     *
     * @return bool
     */
    protected function canInherit(
        string $argumentName,
        array $argumentDefinition,
        ArgumentCollectionInterface $resolvedArgumentCollection
    ): bool {
        return (isset($argumentDefinition['inherit']) && $resolvedArgumentCollection->hasArgument($argumentName));
    }

    /**
     * @param string $argumentName
     * @param array $argumentDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArgumentCollection
     *
     * @return mixed
     */
    protected function getKnownValueForArgument(
        string $argumentName,
        array $argumentDefinition,
        ArgumentCollectionInterface $resolvedArgumentCollection
    ) {
        if (isset($argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUE]) && !$this->issetNonEmptyOption($argumentName)) {
            return $argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_VALUE];
        }

        if ($this->canInherit($argumentName, $argumentDefinition, $resolvedArgumentCollection)) {
            return $resolvedArgumentCollection->getArgument($argumentName)->getValue();
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
     * @param array $argumentDefinition
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArgumentCollection
     *
     * @return mixed|null
     */
    protected function getDefaultValue(
        string $argumentName,
        array $argumentDefinition,
        ArgumentCollectionInterface $resolvedArgumentCollection
    ) {
        if (isset($argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_DEFAULT])) {
            return $argumentDefinition[SprykConfig::NAME_ARGUMENT_KEY_DEFAULT];
        }

        if ($resolvedArgumentCollection->hasArgument($argumentName)) {
            $argumentValue = $resolvedArgumentCollection->getArgument($argumentName)->getValue();
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
        $question = new Question(
            sprintf('Enter value for <fg=yellow>%s.%s</> argument', $sprykName, $argument),
            $default,
        );
        $question->setNormalizer(function ($value) {
            return $value ?: '';
        });

        if ($allowEmpty === false) {
            $question->setValidator(function ($value) use ($argument, $sprykName) {
                if (!is_string($value) && !is_bool($value)) {
                    throw new InvalidArgumentException(sprintf('No value or empty value for argument "%s" used in spryk "%s".', $argument, $sprykName));
                }

                return $value;
            });
        }

        return $this->style->askQuestion($question);
    }

    /**
     * @param string $argument
     * @param string $sprykName
     * @param array<string>|array<int>|array<null> $values
     * @param string|int|null $default
     *
     * @return string|int|null
     */
    protected function choseArgumentValue(string $argument, string $sprykName, array $values, $default)
    {
        $question = new ChoiceQuestion(
            sprintf('Enter value for <fg=yellow>%s.%s</> argument', $sprykName, $argument),
            $values,
            $default,
        );

        return $this->style->askQuestion($question);
    }
}
