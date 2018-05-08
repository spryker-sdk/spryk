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
     * @var \Spryker\Spryk\Style\SprykStyleInterface
     */
    protected $style;

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $argumentCollection
     */
    public function __construct(ArgumentCollectionInterface $argumentCollection)
    {
        $this->argumentCollection = $argumentCollection;
    }

    /**
     * @param array $arguments
     * @param \Spryker\Spryk\Style\SprykStyleInterface $style
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function resolve(array $arguments, SprykStyleInterface $style): ArgumentCollectionInterface
    {
        $this->style = $style;

        foreach ($arguments as $argumentName => $definition) {
            if ($definition === null) {
                $value = $this->askForArgumentValue($argumentName);

                $argument = new Argument();
                $argument
                    ->setName($argumentName)
                    ->setValue($value);

                $this->argumentCollection->addArgument($argument);

                continue;
            }

            if (isset($definition['default'])) {
                $value = $this->askForArgumentValue($argumentName, $definition['default']);

                $argument = new Argument();
                $argument
                    ->setName($argumentName)
                    ->setValue($value);

                $this->argumentCollection->addArgument($argument);
            }

            if (isset($definition['value'])) {
                $argument = new Argument();
                $argument
                    ->setName($argumentName)
                    ->setValue($definition['value']);

                $this->argumentCollection->addArgument($argument);
            }
        }

        return $this->replacePlaceholderInValues($this->argumentCollection);
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
    protected function askForArgumentValue(string $argument, $default = null)
    {
        $question = new Question(sprintf('Enter value for <fg=yellow>%s</> argument', $argument), $default);

        return $this->style->askQuestion($question);
    }
}
