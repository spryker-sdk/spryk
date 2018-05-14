<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Resolver;

use Spryker\Spryk\Model\Spryk\Definition\Argument\Argument;
use Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;
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
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface[]
     */
    protected $resolvedSprykArgumentCollection = [];

    /**
     * @var \Spryker\Spryk\Style\SprykStyleInterface
     */
    protected $style;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     */
    public function __construct(ArgumentCollectionInterface $argumentCollection)
    {
        $this->argumentCollection = $argumentCollection;
        $this->resolvedArgumentCollection = clone $argumentCollection;
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
//        if (isset($this->resolvedSprykArgumentCollection[$sprykName])) {
//            return $this->resolvedSprykArgumentCollection[$sprykName];
//        }

        $this->style = $style;
        $argumentCollection = clone $this->argumentCollection;

        foreach ($arguments as $argumentName => $definition) {
            $value = $this->getValueForArgument($argumentName, $sprykName, $definition);

            $argument = new Argument();
            $argument
                ->setName($argumentName)
                ->setValue($value);

            $argumentCollection->addArgument($argument);
            $this->resolvedArgumentCollection->addArgument($argument);
        }

        $argumentCollection = $this->replacePlaceholderInValues($argumentCollection);

        $this->resolvedSprykArgumentCollection[$sprykName] = $argumentCollection;

        return $argumentCollection;
    }

    /**
     * @param string $argumentName
     * @param string $sprykName
     * @param array|null $definition
     *
     * @return mixed
     */
    protected function getValueForArgument(string $argumentName, string $sprykName, ?array $definition = null)
    {
        if (isset($definition['value'])) {
            return $definition['value'];
        }

        if (OptionsContainer::hasOption($argumentName)) {
            return OptionsContainer::getOption($argumentName);
        }

        $defaultValue = $this->getDefaultValue($argumentName, $definition);

        return $this->askForArgumentValue($argumentName, $sprykName, $defaultValue);
    }

    /**
     * @param string $argument
     * @param array|null $definition
     *
     * @return mixed|null
     */
    protected function getDefaultValue(string $argument, ?array $definition = null)
    {
        if (isset($definition['default'])) {
            return $definition['default'];
        }

        if ($this->resolvedArgumentCollection->hasArgument($argument)) {
            $argumentValue = $this->resolvedArgumentCollection->getArgument($argument)->getValue();
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
        foreach ($argumentCollection->getArguments() as $resolvedArgument) {
            if (is_array($resolvedArgument->getValue())) {
                continue;
            }

            $search = '%' . $resolvedArgument->getName() . '%';
            $replace = $resolvedArgument->getValue();
            $value = str_replace($search, $replace, $argument->getValue());

            $argument->setValue($value);
        }
    }

    /**
     * @param string $argument
     * @param string|int|null $default
     *
     * @return mixed
     */
    protected function askForArgumentValue(string $argument, string $sprykName, $default = null)
    {
        $question = new Question(sprintf('Enter value for <fg=yellow>%s.%s</> argument', $sprykName, $argument), $default);

        return $this->style->askQuestion($question);
    }
}
