<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Argument;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface;
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
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface
     */
    protected $superseder;

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
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder\SupersederInterface $superseder
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Callback\Resolver\CallbackArgumentResolverInterface $callbackArgumentResolver
     */
    public function __construct(ArgumentCollectionInterface $argumentCollection, SupersederInterface $superseder, CallbackArgumentResolverInterface $callbackArgumentResolver)
    {
        $this->argumentCollection = $argumentCollection;
        $this->resolvedArgumentCollection = clone $argumentCollection;
        $this->superseder = $superseder;
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

        $argumentCollection = $this->superseder->supersede($argumentCollection, $this->resolvedArgumentCollection);
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
