<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Spryk\Model\Spryk\Definition\Argument\Collection;

use Spryker\Spryk\Exception\ArgumentNotFoundException;
use Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface;

class ArgumentCollection implements ArgumentCollectionInterface
{
    /**
     * @var \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface[]
     */
    protected $arguments = [];

    /**
     * @param \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface $argument
     *
     * @return $this
     */
    public function addArgument(ArgumentInterface $argument): ArgumentCollectionInterface
    {
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
     * @throws \Spryker\Spryk\Exception\ArgumentNotFoundException
     *
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface
     */
    public function getArgument(string $name): ArgumentInterface
    {
        if (!$this->hasArgument($name)) {
            throw new ArgumentNotFoundException(sprintf('Argument "%s" could not be found. Maybe there is a typo in your spryk definition.', $name));
        }

        return $this->arguments[$name];
    }

    /**
     * @return \Spryker\Spryk\Model\Spryk\Definition\Argument\ArgumentInterface[]
     */
    public function getArguments(): array
    {
        return $this->arguments;
    }
}
