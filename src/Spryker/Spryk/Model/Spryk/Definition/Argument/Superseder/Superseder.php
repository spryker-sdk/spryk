<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder;

use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRenderer;
use Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class Superseder implements SupersederInterface
{
    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $sprykArguments
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArguments
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface
     */
    public function supersede(ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments): ArgumentCollectionInterface
    {
        foreach ($sprykArguments->getArguments() as $argument) {
            if ($argument->getValue() === null) {
                continue;
            }
            $this->replacePlaceholder($argument, $sprykArguments, $resolvedArguments);
        }

        return $sprykArguments;
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $sprykArguments
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArguments
     *
     * @return void
     */
    protected function replacePlaceholder(ArgumentInterface $argument, ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments): void
    {
        $argumentValue = $argument->getValue();

        if (!is_array($argumentValue)) {
            $argument->setValue(
                $this->replacePlaceholderInValue($argumentValue, $sprykArguments, $resolvedArguments)
            );

            return;
        }

        $argumentValues = [];
        foreach ($argumentValue as $value) {
            $argumentValues[] = $this->replacePlaceholderInValue($value, $sprykArguments, $resolvedArguments);
        }
        $argument->setValue($argumentValues);
    }

    /**
     * @param string $argumentValue
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $sprykArguments
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArguments
     *
     * @return string
     */
    protected function replacePlaceholderInValue(string $argumentValue, ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments): string
    {
        preg_match_all('/{{(.*?)}}/', $argumentValue, $matches, PREG_SET_ORDER);

        if (count($matches) === 0) {
            return $argumentValue;
        }

        $valueRenderer = new TemplateRenderer([]);

        $replacements = [];
        foreach ($matches as $match) {
            $argumentName = trim($match[1]);
            $resolvedArgumentValue = $this->getAlreadyResolvedValue($argumentName, $sprykArguments, $resolvedArguments);
            $replacements[$argumentName] = $resolvedArgumentValue;
        }

        $argumentValue = $valueRenderer->render($argumentValue, $replacements);

        return $argumentValue;
    }

    /**
     * @param string $argumentName
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $sprykArguments
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArguments
     *
     * @return mixed
     */
    protected function getAlreadyResolvedValue(string $argumentName, ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments)
    {
        if ($sprykArguments->hasArgument($argumentName)) {
            return $resolvedArguments->getArgument($argumentName)->getValue();
        }

        return $resolvedArguments->getArgument($argumentName)->getValue();
    }
}
