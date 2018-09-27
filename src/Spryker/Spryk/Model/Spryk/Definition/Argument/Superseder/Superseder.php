<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Superseder;

use Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;
use Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface;

class Superseder implements SupersederInterface
{
    public const PLACEHOLDER_PATTERN = '/{{(.*?)[}|\|]/';

    /**
     * @var \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface
     */
    protected $templateRenderer;

    /**
     * @var string[]
     */
    protected $resolvedArguments = [];

    /**
     * @param \Spryker\Spryk\Model\Spryk\Builder\Template\Renderer\TemplateRendererInterface $templateRenderer
     */
    public function __construct(TemplateRendererInterface $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

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
            $this->resolveArgument($argument, $sprykArguments, $resolvedArguments);
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
    protected function resolveArgument(ArgumentInterface $argument, ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments): void
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
        preg_match_all(static::PLACEHOLDER_PATTERN, $argumentValue, $matches, PREG_SET_ORDER);

        if (count($matches) === 0) {
            return $argumentValue;
        }

        $replacements = [];
        foreach ($matches as $match) {
            $argumentName = trim($match[1]);
            $resolvedArgumentValue = $this->getResolvedValue($argumentName, $sprykArguments, $resolvedArguments);
            $replacements[$argumentName] = $resolvedArgumentValue;
        }

        $argumentValue = $this->templateRenderer->renderString($argumentValue, $replacements);

        return $argumentValue;
    }

    /**
     * @param string $argumentName
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $sprykArguments
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArguments
     *
     * @return mixed
     */
    protected function getResolvedValue(string $argumentName, ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments)
    {
        $argument = $resolvedArguments->getArgument($argumentName);

        return $this->resolveValue($argument, $sprykArguments, $resolvedArguments);
    }

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $sprykArguments
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\Collection\ArgumentCollectionInterface $resolvedArguments
     *
     * @return mixed
     */
    protected function resolveValue(ArgumentInterface $argument, ArgumentCollectionInterface $sprykArguments, ArgumentCollectionInterface $resolvedArguments)
    {
        $value = $argument->getValue();

        if ($this->argumentHasPlaceholder($value)) {
            $this->resolveArgument($argument, $sprykArguments, $resolvedArguments);
        }

        return $argument->getValue();
    }

    /**
     * @param string $argumentValue
     *
     * @return bool
     */
    protected function argumentHasPlaceholder(string $argumentValue): bool
    {
        preg_match_all(static::PLACEHOLDER_PATTERN, $argumentValue, $matches, PREG_SET_ORDER);

        if (count($matches) === 0) {
            return false;
        }

        return true;
    }
}
