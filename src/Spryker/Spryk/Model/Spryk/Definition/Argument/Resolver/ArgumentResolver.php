<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Argument;
use Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use Spryker\Spryk\Style\SprykStyleInterface;
use Symfony\Component\Console\Question\Question;

class ArgumentResolver implements ArgumentResolverInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $argumentCollection;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected $resolvedArgumentCollection;

    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface
     */
    protected $callbackArgumentResolver;

    /**
     * @var \Spryker\Spryk\Style\SprykStyleInterface
     */
    protected $style;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface $callbackArgumentResolver
     */
    public function __construct(ArgumentCollectionInterface $argumentCollection, CallbackArgumentResolverInterface $callbackArgumentResolver)
    {
        $this->argumentCollection = $argumentCollection;
        $this->resolvedArgumentCollection = clone $argumentCollection;
        $this->callbackArgumentResolver = $callbackArgumentResolver;
    }

    /**
     * @param array $arguments
     * @param string $sprykName
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(array $arguments, string $sprykName, SprykStyleInterface $style): ArgumentCollectionInterface
    {
        $this->style = $style;
        $argumentCollection = clone $this->argumentCollection;

        foreach ($arguments as $argumentName => $argumentDefinition) {
            $argument = $this->resolveArgument($argumentName, $sprykName, $argumentDefinition);
            $argumentCollection->addArgument($argument);
            $this->resolvedArgumentCollection->addArgument($argument);
        }

        $argumentCollection = $this->replacePlaceholderInValues($argumentCollection);
        $argumentCollection = $this->callbackArgumentResolver->resolve($argumentCollection);

        return $argumentCollection;
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array|null $argumentDefinition
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Argument
     */
    protected function resolveArgument(string $argumentName, string $sprykName, ?array $argumentDefinition = null): Argument
    {
        $argument = new Argument();
        $argument->setName($argumentName);

        if (isset($argumentDefinition['callback'])) {
            $argument->setCallbacks((array)$argumentDefinition['callback']);
        }

        if (isset($argumentDefinition['callbackOnly'])) {
            return $argument;
        }

        $value = $this->getValueForArgument($argumentName, $sprykName, $argumentDefinition);
        $argument->setValue($value);

        return $argument;
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array|null $argumentDefinition
     *
     * @return mixed
     */
    protected function getValueForArgument(string $argumentName, string $sprykName, ?array $argumentDefinition = null)
    {
        if (isset($argumentDefinition['value'])) {
            return $argumentDefinition['value'];
        }

        if (OptionsContainer::hasOption($argumentName)) {
            return OptionsContainer::getOption($argumentName);
        }

        $defaultValue = $this->getDefaultValue($argumentName, $argumentDefinition);

        return $this->askForArgumentValue($argumentName, $sprykName, $defaultValue);
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
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    protected function replacePlaceholderInValues(ArgumentCollectionInterface $argumentCollection): ArgumentCollectionInterface
    {
        foreach ($argumentCollection->getArguments() as $argument) {
            if ($this->hasPlaceholder($argument)) {
                $this->replacePlaceholder($argument, $argumentCollection);
            }
        }

        return $argumentCollection;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     *
     * @return bool
     */
    protected function hasPlaceholder(ArgumentInterface $argument): bool
    {
        $values = (array)$argument->getValue();
        foreach ($values as $value) {
            if (preg_match('/%.+%/', $value)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return void
     */
    protected function replacePlaceholder(ArgumentInterface $argument, ArgumentCollectionInterface $argumentCollection): void
    {
        $argumentValue = $argument->getValue();
        if (!is_array($argumentValue)) {
            $argument->setValue(
                $this->replacePlaceholderInValue($argumentValue, $argumentCollection)
            );

            return;
        }

        $argumentValues = [];
        foreach ($argumentValue as $value) {
            $argumentValues[] = $this->replacePlaceholderInValue($value, $argumentCollection);
        }
        $argument->setValue($argumentValues);
    }

    /**
     * @param string $argumentValue
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return string
     */
    protected function replacePlaceholderInValue(string $argumentValue, ArgumentCollectionInterface $argumentCollection): string
    {
        preg_match_all('/%(.*?)%/', $argumentValue, $matches, PREG_SET_ORDER);

        if (count($matches) === 0) {
            return $argumentValue;
        }

        foreach ($matches as $match) {
            $argumentName = $match[1];
            $placeholder = $match[0];
            if ($this->isAlreadyResolved($argumentName, $argumentCollection)) {
                $resolvedArgumentValue = $this->getAlreadyResolvedValue($argumentName, $argumentCollection);
                $argumentValue = str_replace($placeholder, $resolvedArgumentValue, $argumentValue);
            }
        }

        return $argumentValue;
    }

    /**
     * @param string $argumentName
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return bool
     */
    protected function isAlreadyResolved(string $argumentName, ArgumentCollectionInterface $argumentCollection): bool
    {
        if ($argumentCollection->hasArgument($argumentName) || $this->resolvedArgumentCollection->hasArgument($argumentName)) {
            return true;
        }

        return false;
    }

    /**
     * @param string $argumentName
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     *
     * @return mixed
     */
    protected function getAlreadyResolvedValue(string $argumentName, ArgumentCollectionInterface $argumentCollection)
    {
        if ($argumentCollection->hasArgument($argumentName)) {
            return $argumentCollection->getArgument($argumentName)->getValue();
        }

        return $this->resolvedArgumentCollection->getArgument($argumentName)->getValue();
    }

    /**
     * @param string $argument
     * @param string $sprykName
     * @param string|int|null $default
     *
     * @return string|int|null
     */
    protected function askForArgumentValue(string $argument, string $sprykName, $default = null)
    {
        $question = new Question(sprintf('Enter value for <fg=yellow>%s.%s</> argument', $sprykName, $argument), $default);

        return $this->style->askQuestion($question);
    }
}
