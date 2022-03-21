<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Spryk\Model\Spryk\Definition\Argument\Collection;

use SprykerSdk\Spryk\Exception\ArgumentNotFoundException;
use SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;
use SprykerSdk\Spryk\SprykConfig;

class ArgumentCollection implements ArgumentCollectionInterface
{
    /**
     * @var array<\SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface>
     */
    protected $arguments = [];

    /**
     * @param \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     *
     * @return $this
     */
    public function addArgument(ArgumentInterface $argument)
    {
        // Do not override the first found argument.
        if (isset($this->arguments[$argument->getName()])) {
            return $this;
        }

        $this->arguments[$argument->getName()] = $argument;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public function hasArgument(string $name): bool
    {
        return isset($this->arguments[$name]);
    }

    /**
     * @param string $name
     *
     * @throws \SprykerSdk\Spryk\Exception\ArgumentNotFoundException
     *
     * @return \SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function getArgument(string $name): ArgumentInterface
    {
        if (!$this->hasArgument($name)) {
            throw new ArgumentNotFoundException(sprintf('Argument "%s" could not be found. Maybe there is a typo in your spryk definition.', $name));
        }

        return $this->arguments[$name];
    }

    /**
     * @return array<\SprykerSdk\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface>
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }

    /**
     * @return array
     */
    public function getArgumentsAsArray(): array
    {
        $result = [];

        foreach ($this->arguments as $argument) {
            $result[$argument->getName()][SprykConfig::NAME_ARGUMENT_KEY_VALUE] = $argument->getValue();
        }

        return $result;
    }

    /**
     * @return string
     */
    public function getFingerprint(): string
    {
        $argumentsArray = $this->getArgumentsAsArray();
        ksort($argumentsArray);

        return sha1((string)json_encode($argumentsArray));
    }
}
